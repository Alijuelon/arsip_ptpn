<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriDokumen;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriDokumen::orderBy('nama_kategori', 'asc')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'kode_kategori' => 'required|string|max:20|unique:kategori_dokumens,kode_kategori',
        ]);

        KategoriDokumen::create([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => strtoupper($request->kode_kategori) // Memastikan kode selalu huruf besar
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori dokumen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriDokumen::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'kode_kategori' => 'required|string|max:20|unique:kategori_dokumens,kode_kategori,' . $id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => strtoupper($request->kode_kategori)
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $kategori = KategoriDokumen::findOrFail($id);
            $kategori->delete();

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori berhasil dihapus!');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal menghapus! Kategori ini masih digunakan oleh dokumen arsip.');
        }
    }
}