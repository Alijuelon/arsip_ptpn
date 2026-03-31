<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\ValidasiDokumen;
use App\Models\ArsipDokumen;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiDokumenController extends Controller
{
    /**
     * Menampilkan daftar dokumen yang menunggu verifikasi.
     */
    public function index()
    {
        // Mengambil dokumen dengan status 'Menunggu' beserta data relasinya
        $dokumenPending = Dokumen::with(['pengirim.departemen', 'kategori'])
            ->where('status_dokumen', 'Menunggu')
            ->orderBy('created_at', 'asc') // Yang paling lama menunggu diutamakan
            ->get();

        return view('admin.verifikasi.index', compact('dokumenPending'));
    }

    /**
     * Memproses keputusan validasi (Setuju / Tolak).
     */
    public function store(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'status_validasi' => 'required|in:Disetujui,Ditolak',
            'catatan_validasi' => 'required|string',
            'lokasi_arsip' => 'nullable|string|max:100' // Opsional, hanya diisi jika Disetujui
        ]);

        // Cari dokumen berdasarkan ID
        $dokumen = Dokumen::findOrFail($id);

        // Menggunakan Database Transaction agar jika ada error di tengah jalan, semua dibatalkan (rollback)
        DB::beginTransaction();
        try {
            // 1. Simpan data validasi ke tabel validasi_dokumens
            ValidasiDokumen::create([
                'dokumen_id' => $dokumen->id,
                'admin_id' => Auth::id(),
                'status_validasi' => $request->status_validasi,
                'catatan_validasi' => $request->catatan_validasi
            ]);

            // 2. Update status di tabel dokumens
            $dokumen->update([
                'status_dokumen' => $request->status_validasi
            ]);

            // 3. Jika disetujui, otomatis masukkan ke tabel arsip_dokumens
            if ($request->status_validasi === 'Disetujui') {
                ArsipDokumen::create([
                    'dokumen_id' => $dokumen->id,
                    'lokasi_arsip' => $request->lokasi_arsip ?? 'Belum ditentukan',
                    'staff_id' => Auth::id() // Admin yang mengarsipkan
                ]);
            }

            // 4. Catat ke Riwayat Aktivitas (Audit Log)
            RiwayatAktivitas::create([
                'user_id' => Auth::id(),
                'aksi' => 'Validasi Dokumen',
                'deskripsi_aktivitas' => 'Admin ' . Auth::user()->nama_user . ' melakukan validasi (' . $request->status_validasi . ') pada dokumen: ' . $dokumen->judul_dokumen
            ]);

            DB::commit(); // Simpan semua perubahan ke database secara permanen

            return redirect()->route('admin.verifikasi.index')
                ->with('success', 'Dokumen berhasil divalidasi dengan status: ' . $request->status_validasi);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua operasi jika terjadi error
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}