<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardKaryawanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung total upload dokumen di bulan ini
        $uploadBulanIni = Dokumen::where('pengirim_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 2. Hitung dokumen yang ditolak
        $ditolakAdmin = Dokumen::where('pengirim_id', $userId)
            ->where('status_dokumen', 'Ditolak')
            ->count();

        // 3. Hitung dokumen masuk (Inbox/Disposisi) yang belum dibaca
        $inboxBaru = Disposisi::where('penerima_id', $userId)
            ->where('status_baca', false)
            ->count();

        // 4. Ambil 5 aktivitas upload terakhir
        $aktivitasTerbaru = Dokumen::where('pengirim_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('karyawan.dashboard', compact(
            'uploadBulanIni', 
            'ditolakAdmin', 
            'inboxBaru', 
            'aktivitasTerbaru'
        ));
    }
}