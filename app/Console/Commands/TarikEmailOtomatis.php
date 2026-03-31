<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\EmailMasuk;
use App\Models\Pengaturan;
use App\Models\Dokumen;
use App\Models\ArsipDokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TarikEmailOtomatis extends Command
{
    // Nama perintah untuk dijalankan di terminal
    protected $signature = 'email:tarik';

    // Deskripsi perintah
    protected $description = 'Menarik email dari Gmail secara otomatis di background';

    public function handle()
    {
        $this->info('Memulai pengecekan email otomatis...');

        // Cari pengaturan email pusat
        $pengaturanEmail = Pengaturan::where('kunci', 'email_pusat')->first();
        $emailPusat = $pengaturanEmail ? $pengaturanEmail->nilai : 'pusat@ptpn4.co.id';

        // Cari kategori default untuk arsip
        $kategoriTersedia = \Illuminate\Support\Facades\DB::table('kategori_dokumens')->first();
        if (!$kategoriTersedia) {
            $this->error('Kategori kosong. Auto-Arsip dibatalkan.');
            return;
        }

        // Ambil SEMUA staf yang sudah menghubungkan akun Gmail mereka
        $users = User::whereNotNull('google_access_token')->get();

        if ($users->isEmpty()) {
            $this->info('Belum ada staf yang menghubungkan Gmail.');
            return;
        }

        foreach ($users as $user) {
            $this->info("Mengecek email untuk staf: {$user->google_email}");

            // Setup Google Client untuk staf ini
            $client = new \Google\Client();
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setAccessToken($user->google_access_token);

            // Perbarui token jika expired
            if ($client->isAccessTokenExpired()) {
                if ($user->google_refresh_token) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                    if (isset($newToken['error'])) {
                        $user->update(['google_access_token' => null, 'google_refresh_token' => null]);
                        $this->error("Token staf {$user->name} kedaluwarsa permanen.");
                        continue;
                    }
                    $user->update(['google_access_token' => $newToken['access_token']]);
                    $client->setAccessToken($newToken['access_token']);
                } else {
                    continue;
                }
            }

            $service = new \Google\Service\Gmail($client);
            $optParams = [
                'q' => "from:{$emailPusat}",
                'maxResults' => 5 // Cek 5 pesan terbaru saja agar cepat
            ];
            
            try {
                $results = $service->users_messages->listUsersMessages('me', $optParams);
                $messages = $results->getMessages();

                if (empty($messages)) {
                    continue; // Skip jika tidak ada pesan
                }

                foreach ($messages as $message) {
                    $msgId = $message->getId();

                    // Jika email sudah ada di database, lewati
                    if (EmailMasuk::where('gmail_id', $msgId)->exists()) continue;

                    // Ambil detail pesan
                    $msgDetail = $service->users_messages->get('me', $msgId);
                    $payload = $msgDetail->getPayload();
                    $headers = $payload->getHeaders();
                    
                    $subject = 'Tanpa Subjek';
                    $from = $emailPusat;
                    $tanggalGmail = now();

                    foreach ($headers as $header) {
                        if ($header->getName() === 'Subject') $subject = $header->getValue();
                        if ($header->getName() === 'From') $from = $header->getValue();
                        if ($header->getName() === 'Date') $tanggalGmail = Carbon::parse($header->getValue());
                    }

                    $snippet = $msgDetail->getSnippet(); 

                    // Ekstrak Lampiran
                    $fileLampiran = null;
                    $namaFile = null;
                    $parts = $payload->getParts();

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

                                    $filenameLokal = time() . '_' . Str::slug(pathinfo($namaFile, PATHINFO_FILENAME)) . '.' . pathinfo($namaFile, PATHINFO_EXTENSION);
                                    $path = 'lampiran_email/' . $filenameLokal;
                                    
                                    Storage::disk('public')->put($path, $fileContent);
                                    $fileLampiran = $path;
                                    break; 
                                }
                            }
                        }
                    }

                    $isArchived = $fileLampiran ? true : false;
                    
                    // Simpan ke Tabel Email Masuk
                    EmailMasuk::create([
                        'gmail_id' => $msgId,
                        'pengirim' => $from,
                        'subjek' => $subject,
                        'isi_pesan' => html_entity_decode($snippet),
                        'tanggal_terima' => $tanggalGmail,
                        'nama_file' => $namaFile,           
                        'file_lampiran' => $fileLampiran,
                        'is_read' => $isArchived,
                        'is_archived' => $isArchived
                    ]);

                    // LOGIKA AUTO-ARSIP
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
                        $this->info("-> Berhasil mengarsipkan: {$namaFile}");
                    }
                }

            } catch (\Exception $e) {
                $this->error("Gagal menarik email untuk {$user->name}: " . $e->getMessage());
            }
        }

        $this->info('Selesai mengecek email otomatis.');
    }
}