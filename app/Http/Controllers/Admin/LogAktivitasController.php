<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LogUnduh;

class LogAktivitasController extends Controller
{
    public function index()
    {
        // Ambil semua log, urutkan dari yang terbaru
        $logs = LogUnduh::with(['user', 'dokumen'])->latest()->paginate(20);
        return view('admin.log.index', compact('logs'));
    }
}