<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArsipDokumen;
use App\Models\KategoriDokumen;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;

class DataArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim'])->latest();

        // Fitur Filter (Opsional, agar Pimpinan juga bisa mencari arsip dengan mudah)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dokumen', function($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%");
            });
        }
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $query->whereHas('dokumen', function($q) use ($kategori) {
                $q->where('kategori_id', $kategori);
            });
        }

        $arsip = $query->paginate(15);
        $kategoris = KategoriDokumen::all();

        return view('pimpinan.arsip.index', compact('arsip', 'kategoris'));
    }

    // Fungsi Hapus Arsip (Hak istimewa Admin & Pimpinan)
    public function destroy($id)
    {
        $arsip = ArsipDokumen::findOrFail($id);
        $dokumen = $arsip->dokumen;

        // Hapus file dari penyimpanan
        if ($dokumen && $dokumen->file_dokumen) {
            Storage::disk('public')->delete($dokumen->file_dokumen);
        }

        // Hapus dari database (akan menghapus arsip & dokumen karena relasi atau dihapus manual)
        $arsip->delete();
        if($dokumen) $dokumen->delete();

        return back()->with('success', 'Dokumen beserta file fisiknya berhasil dihapus permanen dari Arsip Utama.');
    }
}