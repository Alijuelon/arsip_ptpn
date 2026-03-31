<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokumen;
class KotakMasukController extends Controller
{
    /**
     * Menampilkan daftar dokumen yang masuk / didisposisikan ke karyawan.
     */
    public function index()
    {
        // 1. Ambil dokumen dari Pimpinan (status 'Disposisi')
        $suratMasuk = Dokumen::with('pengirim')
            ->where('status_dokumen', 'Disposisi')
            ->latest()
            ->paginate(10); // Menggunakan paginate agar halamannya rapi

        // 2. Kirim data ke tampilan Blade
        return view('karyawan.inbox.index', compact('suratMasuk'));
    }

    /**
     * Mengubah status dokumen masuk menjadi 'Sudah Dibaca'.
     * (Opsional: Tambahkan Route::post('/inbox/{id}/read', ...) di web.php untuk fitur ini)
     */
    public function markAsRead($id)
    {
        $disposisi = Disposisi::where('id', $id)
            ->where('penerima_id', Auth::id()) // Pastikan ini milik user yang login
            ->firstOrFail();

        $disposisi->update([
            'status_baca' => true
        ]);

        return back()->with('success', 'Dokumen ditandai telah dibaca.');
    }
}