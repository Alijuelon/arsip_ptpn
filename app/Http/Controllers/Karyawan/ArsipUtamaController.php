<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\ArsipDokumen;
use App\Models\KategoriDokumen; // Wajib panggil model Kategori
use Illuminate\Http\Request;

class ArsipUtamaController extends Controller
{
    public function index(Request $request)
    {
        // Mulai Query Dasar (Relasi)
        $query = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim'])->latest();

        // 1. Logika Filter Pencarian Judul
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dokumen', function($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%");
            });
        }

        // 2. Logika Filter Kategori
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $query->whereHas('dokumen', function($q) use ($kategori) {
                $q->where('kategori_id', $kategori);
            });
        }

        // Eksekusi Query dengan Pagination
        $arsip = $query->paginate(15);
        
        // Ambil data kategori untuk dropdown filter di UI
        $kategoris = KategoriDokumen::all();

        return view('karyawan.arsip.index', compact('arsip', 'kategoris'));
    }
}