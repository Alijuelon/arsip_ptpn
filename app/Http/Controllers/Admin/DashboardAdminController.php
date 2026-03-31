<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokumen;
use App\Models\ArsipDokumen;

class DashboardAdminController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Admin
     */
    public function index()
    {
        // 1. Mengambil data statistik untuk Card di atas
        $totalPengguna = User::count();
        $totalArsip = ArsipDokumen::count();
        
        // Menghitung dokumen yang statusnya masih 'Menunggu' validasi
        $menungguVerifikasi = Dokumen::where('status_dokumen', 'Menunggu')->count();
        
        // Menghitung dokumen yang statusnya 'Ditolak'
        $dokumenDitolak = Dokumen::where('status_dokumen', 'Ditolak')->count();

        // 2. Mengambil data antrean verifikasi terbaru (maksimal 5 data untuk tabel di dashboard)
        // Menggunakan Eager Loading (with) agar relasi ke pengirim dan departemennya ikut terambil
        $dokumenTerbaru = Dokumen::with(['pengirim.departemen', 'kategori'])
            ->where('status_dokumen', 'Menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Mengirim data ke view (Pastikan Anda sudah memisahkan view HTML sebelumnya ke resources/views/admin/dashboard.blade.php)
        return view('admin.dashboard', compact(
            'totalPengguna', 
            'totalArsip', 
            'menungguVerifikasi', 
            'dokumenDitolak',
            'dokumenTerbaru'
        ));
    }
}