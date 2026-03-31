<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArsipDokumen;
use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardPimpinanController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Pimpinan.
     */
    public function index()
    {
        // 1. Statistik Makro Perusahaan
        $totalArsip = ArsipDokumen::count();
        $totalKaryawan = User::where('role', 'Staff')->count();
        
        // Memantau kinerja Admin (Berapa dokumen yang belum diurus)
        $dokumenPending = Dokumen::where('status_dokumen', 'Menunggu')->count();

        // 2. Mengambil 5 Arsip Terbaru yang disahkan masuk ke database pusat
        $arsipTerbaru = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim.departemen'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pimpinan.dashboard', compact(
            'totalArsip', 
            'totalKaryawan', 
            'dokumenPending', 
            'arsipTerbaru'
        ));
    }
}