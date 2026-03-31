<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailMasuk;
use App\Models\Pengaturan;
use App\Models\Dokumen;
use App\Models\ArsipDokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmailPusatController extends Controller
{
    // 1. Menampilkan Halaman Inbox ala Gmail
    public function index()
    {
        // Ambil alamat email pusat dari database
        $pengaturanEmail = Pengaturan::where('kunci', 'email_pusat')->first();
        $emailPusat = $pengaturanEmail ? $pengaturanEmail->nilai : 'Belum diatur';

        // Ambil daftar email masuk yang belum diarsipkan
        $emails = EmailMasuk::where('is_archived', false)
                    ->orderBy('tanggal_terima', 'desc')
                    ->paginate(15);

        return view('karyawan.email.index', compact('emails', 'emailPusat'));
    }

    // 2. Simpan Pengaturan Alamat Email Pusat
    public function simpanPengaturan(Request $request)
    {
        $request->validate(['email_pusat' => 'required|email']);

        Pengaturan::updateOrCreate(
            ['kunci' => 'email_pusat'],
            ['nilai' => $request->email_pusat]
        );

        return back()->with('success', 'Alamat Email Pusat berhasil diperbarui! Sistem sekarang memantau email tersebut.');
    }

    // 3. Baca Email (Tandai sudah dibaca)
    public function baca($id)
    {
        $email = EmailMasuk::findOrFail($id);
        $email->update(['is_read' => true]);
        
        return response()->json($email); // Untuk ditampilkan di Modal
    }

    // 4. Proses Eksekusi: Pindahkan Email ke Arsip Utama
    // 4. Proses Eksekusi: Pindahkan Email ke Arsip Utama
    public function arsipkan($id)
    {
        $email = EmailMasuk::findOrFail($id);

        if(!$email->file_lampiran) {
            return back()->with('error', 'Email ini tidak memiliki dokumen lampiran untuk diarsipkan.');
        }

        // --- TAMBAHAN BARU: Cek Kategori Secara Dinamis ---
        // Ambil data kategori pertama yang ada di database
        $kategoriTersedia = \Illuminate\Support\Facades\DB::table('kategori_dokumens')->first();
        
        if (!$kategoriTersedia) {
            return back()->with('error', 'Gagal mengarsipkan: Tabel Kategori Dokumen masih kosong. Minta Admin untuk membuat minimal 1 Kategori terlebih dahulu.');
        }
        // --------------------------------------------------

        // Simpan ke tabel Dokumen
        $dokumen = Dokumen::create([
            'judul_dokumen' => $email->nama_file ?? $email->subjek,
            'kategori_id' => $kategoriTersedia->id, // <-- Ganti angka 1 jadi ID dinamis ini
            'file_dokumen' => $email->file_lampiran,
            'pengirim_id' => Auth::id(),
            'status_dokumen' => 'Disetujui', 
            'keterangan' => "Diarsipkan dari Inbox Pusat. \nSubjek: " . $email->subjek
        ]);

        // Simpan ke tabel Arsip
        ArsipDokumen::create([
            'dokumen_id' => $dokumen->id,
            'lokasi_arsip' => 'Arsip Digital Pusat',
            'staff_id' => Auth::id()
        ]);

        $email->update(['is_archived' => true]);

        return back()->with('success', 'Berhasil! Dokumen dari email ini telah masuk ke Sistem Arsip Utama.');
    }
    // Fungsi untuk menarik email dari Gmail
  // Jangan lupa tambahkan ini di paling atas file Controller jika belum ada:
    // use Illuminate\Support\Facades\Storage;
    // use Illuminate\Support\Str;

   public function syncGmail()
    {
        $user = Auth::user();

        if (!$user->google_access_token) {
            return back()->with('error', 'Silakan hubungkan akun Gmail Anda terlebih dahulu.');
        }

        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessToken($user->google_access_token);

        if ($client->isAccessTokenExpired()) {
            if ($user->google_refresh_token) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                if (isset($newToken['error'])) {
                    $user->update(['google_access_token' => null, 'google_refresh_token' => null]);
                    return back()->with('error', 'Sesi Gmail berakhir. Silakan hubungkan ulang.');
                }
                $user->update(['google_access_token' => $newToken['access_token']]);
                $client->setAccessToken($newToken['access_token']);
            } else {
                return back()->with('error', 'Sesi tidak valid, silakan hubungkan ulang Gmail Anda.');
            }
        }

        $service = new \Google\Service\Gmail($client);

        $pengaturanEmail = Pengaturan::where('kunci', 'email_pusat')->first();
        $emailPusat = $pengaturanEmail ? $pengaturanEmail->nilai : 'pusat@ptpn4.co.id';

        // Persiapan Auto-Arsip: Cari kategori default yang tersedia di database
        $kategoriTersedia = \Illuminate\Support\Facades\DB::table('kategori_dokumens')->first();
        if (!$kategoriTersedia) {
            return back()->with('error', 'Tarik Email dibatalkan: Tabel Kategori kosong. Buat minimal 1 kategori agar sistem bisa melakukan Auto-Arsip.');
        }

        $optParams = [
            'q' => "from:{$emailPusat}",
            'maxResults' => 10
        ];
        
        try {
            $results = $service->users_messages->listUsersMessages('me', $optParams);
            $messages = $results->getMessages();

            if (empty($messages)) {
                return back()->with('success', 'Sinkronisasi selesai. Belum ada email baru dari '.$emailPusat.' di Gmail Anda.');
            }

            $jumlahBaru = 0;
            $jumlahDiarsipkan = 0;

            foreach ($messages as $message) {
                $msgId = $message->getId();

                if (EmailMasuk::where('gmail_id', $msgId)->exists()) continue;

                $msgDetail = $service->users_messages->get('me', $msgId);
                $payload = $msgDetail->getPayload();
                $headers = $payload->getHeaders();
                
                $subject = 'Tanpa Subjek';
                $from = $emailPusat;
                $tanggalGmail = now();

                foreach ($headers as $header) {
                    if ($header->getName() === 'Subject') $subject = $header->getValue();
                    if ($header->getName() === 'From') $from = $header->getValue();
                    if ($header->getName() === 'Date') $tanggalGmail = \Carbon\Carbon::parse($header->getValue());
                }

                $snippet = $msgDetail->getSnippet(); 

                $fileLampiran = null;
                $namaFile = null;
                $parts = $payload->getParts();

                // Proses Ekstrak Lampiran
                if ($parts) {
                    foreach ($parts as $part) {
                        if (!empty($part->getFilename())) {
                            $attachmentId = $part->getBody()->getAttachmentId();
                            if ($attachmentId) {
                                $namaFile = $part->getFilename();
                                $attachmentObj = $service->users_messages_attachments->get('me', $msgId, $attachmentId);
                                $data = $attachmentObj->getData();
                                
                                $data = strtr($data, '-_', '+/');
                                $fileContent = base64_decode($data);

                                $filenameLokal = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($namaFile, PATHINFO_FILENAME)) . '.' . pathinfo($namaFile, PATHINFO_EXTENSION);
                                $path = 'lampiran_email/' . $filenameLokal;
                                
                                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $fileContent);
                                
                                $fileLampiran = $path;
                                break; 
                            }
                        }
                    }
                }

                // 1. Simpan ke Email Masuk (dan langsung tandai 'is_archived' jika ada file)
                $isArchived = $fileLampiran ? true : false;
                
                $emailBaru = EmailMasuk::create([
                    'gmail_id' => $msgId,
                    'pengirim' => $from,
                    'subjek' => $subject,
                    'isi_pesan' => html_entity_decode($snippet),
                    'tanggal_terima' => $tanggalGmail,
                    'nama_file' => $namaFile,           
                    'file_lampiran' => $fileLampiran,
                    'is_read' => $isArchived, // Otomatis dianggap sudah dibaca jika langsung diarsipkan
                    'is_archived' => $isArchived
                ]);

                // 2. LOGIKA AUTO-ARSIP (Otomatis masuk ke Dokumen & Arsip)
                if ($fileLampiran) {
                    $dokumen = Dokumen::create([
                        'judul_dokumen' => $namaFile ?? $subject,
                        'kategori_id' => $kategoriTersedia->id,
                        'file_dokumen' => $fileLampiran,
                        'pengirim_id' => $user->id,
                        'status_dokumen' => 'Disetujui', 
                        'keterangan' => "Auto-Arsip dari Inbox Pusat. \nSubjek: " . $subject
                    ]);

                    ArsipDokumen::create([
                        'dokumen_id' => $dokumen->id,
                        'lokasi_arsip' => 'Arsip Digital Pusat (Auto)',
                        'staff_id' => $user->id
                    ]);

                    $jumlahDiarsipkan++;
                }

                $jumlahBaru++;
            }

            return back()->with('success', "Sinkronisasi berhasil! Ditemukan {$jumlahBaru} email baru. {$jumlahDiarsipkan} dokumen langsung masuk ke Arsip Utama.");

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyinkronkan: ' . $e->getMessage());
        }
    }
}