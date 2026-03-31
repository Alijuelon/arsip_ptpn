<?php
namespace App\Http\Controllers;
use App\Models\Dokumen;
use App\Models\LogUnduh;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function unduh($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        // 1. Catat ke tabel Log (Siapa, Dokumen Apa, Kapan)
        LogUnduh::create([
            'user_id' => Auth::id(),
            'dokumen_id' => $dokumen->id
        ]);

        // 2. Cek apakah file fisik ada
        $path = storage_path('app/public/' . $dokumen->file_dokumen);
        if (!file_exists($path)) {
            return back()->with('error', 'File dokumen fisik tidak ditemukan di server.');
        }

        // 3. Berikan filenya ke browser (bisa di-preview atau langsung didownload)
        return response()->file($path);
    }
}