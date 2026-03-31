<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\KategoriDokumen;
use App\Models\ArsipDokumen;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UploadDokumenController extends Controller
{
    /**
     * Menampilkan daftar riwayat arsip saya
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $query = Dokumen::with(['validasis' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->where('pengirim_id', $userId);

        if ($request->has('cari') && $request->cari != '') {
            $query->where('judul_dokumen', 'like', '%' . $request->cari . '%');
        }

        $dokumens = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('karyawan.dokumen.index', compact('dokumens'));
    }

    /**
     * Menampilkan form upload dokumen baru
     */
    public function create()
    {
        // Kategori masih bisa dikirim jika sewaktu-waktu deteksi otomatis gagal dan butuh input manual
        $kategoris = KategoriDokumen::orderBy('nama_kategori', 'asc')->get();
        return view('karyawan.dokumen.create', compact('kategoris'));
    }

    /**
     * Memproses dan menyimpan dokumen baru ke database & storage (Dengan Auto-Arsip)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data (Kategori tidak lagi wajib 'required' karena akan di-auto)
        $request->validate([
            'judul_dokumen' => 'required|string|max:150',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
            'keterangan' => 'nullable|string'
        ]);

        try {
            // 2. OTOMATISASI: Tentukan Kategori Berdasarkan Judul
            $kategoriId = $this->autoDetectCategory($request->judul_dokumen, $request->kategori_id);

            // 3. Proses Upload File
            $file = $request->file('file_dokumen');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('dokumen', $fileName, 'public');

            // 4. Simpan data ke Database Dokumen (Status LANGSUNG 'Disetujui')
            $dokumen = Dokumen::create([
                'judul_dokumen' => $request->judul_dokumen,
                'kategori_id' => $kategoriId,
                'file_dokumen' => $filePath,
                'pengirim_id' => Auth::id(),
                'status_dokumen' => 'Disetujui', // Bypass verifikasi admin
                'keterangan' => $request->keterangan
            ]);

            // 5. OTOMATISASI: Langsung masukkan ke Arsip Utama Permanen
            ArsipDokumen::create([
                'dokumen_id' => $dokumen->id,
                'lokasi_arsip' => 'Arsip Digital (Otomatis)', // Lokasi fisik default
                'diarsipkan_oleh' => Auth::id(), // Dicatat bahwa sistem/karyawan yg mengarsipkan
            ]);

            // 6. Catat ke Riwayat Aktivitas
            RiwayatAktivitas::create([
                'user_id' => Auth::id(),
                'aksi' => 'Auto-Upload & Arsip',
                'deskripsi_aktivitas' => 'Sistem otomatis mengarsipkan dokumen: ' . $dokumen->judul_dokumen
            ]);

            return redirect()->route('karyawan.dokumen.index')
                ->with('success', 'Hebat! Dokumen Anda berhasil diunggah, dikategorikan otomatis, dan langsung masuk ke Arsip Utama!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah dokumen: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * FUNGSI KECERDASAN BUATAN (AI Sederhana) UNTUK AUTO-KATEGORI
     * Membaca kata kunci dari judul untuk mencocokkan dengan kategori di database
     */
    private function autoDetectCategory($judul, $kategoriInputManual = null)
    {
        // Jika user sengaja memilih kategori secara manual di form, gunakan itu.
        if (!empty($kategoriInputManual)) {
            return $kategoriInputManual;
        }

        $judulLower = strtolower($judul);
        $semuaKategori = KategoriDokumen::all();

        // Kamus Kata Kunci (Keywords Dictionary)
        // Anda bisa menambah kata kunci di sini sesuai kebutuhan PTPN IV
        $kamus = [
            'SDM' => ['cuti', 'pegawai', 'karyawan', 'gaji', 'sk', 'pengangkatan', 'mutasi', 'absen'],
            'Keuangan' => ['laporan', 'uang', 'dana', 'budget', 'anggaran', 'invoice', 'kwitansi', 'pajak'],
            'Teknik' => ['mesin', 'pabrik', 'maintenance', 'perbaikan', 'alat', 'kebun', 'panen'],
            'Administrasi' => ['surat', 'edaran', 'rapat', 'undangan', 'notulen', 'mou'],
        ];

        foreach ($kamus as $namaKategoriMap => $kataKuncis) {
            foreach ($kataKuncis as $kata) {
                // Jika kata kunci ditemukan di dalam judul dokumen
                if (Str::contains($judulLower, $kata)) {
                    // Cari Kategori ID di database yang namanya mirip dengan map kita
                    $kategoriCocok = $semuaKategori->filter(function($item) use ($namaKategoriMap) {
                        return Str::contains(strtolower($item->nama_kategori), strtolower($namaKategoriMap));
                    })->first();

                    if ($kategoriCocok) {
                        return $kategoriCocok->id;
                    }
                }
            }
        }

        // Jika sistem gagal mendeteksi dari judul, masukkan ke kategori default
        // Misalnya ambil kategori pertama yang ada di database (Seringkali kategori "Umum")
        $kategoriDefault = KategoriDokumen::first();
        return $kategoriDefault ? $kategoriDefault->id : null;
    }
}