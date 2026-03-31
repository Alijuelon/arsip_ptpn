<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArsipDokumen;
use App\Models\Dokumen;
use App\Models\KategoriDokumen;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;

class DataArsipController extends Controller
{
    /**
     * Menampilkan tabel seluruh arsip dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Gunakan Eager Loading agar query database tidak lambat
        $query = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim', 'staffPengarsip'])
            ->orderBy('created_at', 'desc');

        // Filter Pencarian berdasarkan Judul Dokumen
        if ($request->has('cari') && $request->cari != '') {
            $query->whereHas('dokumen', function ($q) use ($request) {
                $q->where('judul_dokumen', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter berdasarkan Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('dokumen', function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }

        $arsips = $query->paginate(15);
        $kategoris = KategoriDokumen::all();

        return view('admin.arsip.index', compact('arsips', 'kategoris'));
    }

    /**
     * Menampilkan detail satu arsip tertentu.
     */
    public function show($id)
    {
        $arsip = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim.departemen', 'staffPengarsip'])
            ->findOrFail($id);

        return view('admin.arsip.detail', compact('arsip'));
    }
    public function create()
    {
        $kategoris = \App\Models\KategoriDokumen::all();
        return view('admin.arsip.create', compact('kategoris'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul_dokumen' => 'required',
            'kategori_id' => 'required',
            'file_dokumen' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('file_dokumen');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('lampiran_email', $nama_file, 'public');

        // Langsung simpan ke dokumen dengan status Disetujui
        $dokumen = Dokumen::create([
            'judul_dokumen' => $request->judul_dokumen,
            'kategori_id' => $request->kategori_id,
            'file_dokumen' => $path,
            'pengirim_id' => Auth::id(),
            'status_dokumen' => 'Disetujui',
            'keterangan' => $request->keterangan ?? 'Diunggah langsung oleh Admin'
        ]);

        // Langsung masuk ke Arsip
        ArsipDokumen::create([
            'dokumen_id' => $dokumen->id,
            'lokasi_arsip' => $request->lokasi_arsip ?? 'Arsip Digital Pusat',
            'staff_id' => Auth::id()
        ]);

        return redirect()->route('admin.arsip.index')->with('success', 'Arsip berhasil ditambahkan langsung.');
    }
    /**
     * Mengubah metadata arsip (misal: memindahkan lokasi penyimpanan fisik lemari).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lokasi_arsip' => 'required|string|max:100'
        ]);

        $arsip = ArsipDokumen::findOrFail($id);
        $lokasiLama = $arsip->lokasi_arsip;

        $arsip->update([
            'lokasi_arsip' => $request->lokasi_arsip
        ]);

        // Catat di log riwayat
        RiwayatAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'Update Lokasi Arsip',
            'deskripsi_aktivitas' => "Mengubah lokasi fisik arsip (ID: {$arsip->id}) dari '{$lokasiLama}' menjadi '{$request->lokasi_arsip}'"
        ]);

        return redirect()->route('admin.arsip.show', $id)
            ->with('success', 'Lokasi penyimpanan arsip fisik berhasil diperbarui.');
    }

    /**
     * Menghapus arsip (Soft Delete)
     */
    public function destroy($id)
    {
        $arsip = ArsipDokumen::findOrFail($id);

        RiwayatAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Arsip',
            'deskripsi_aktivitas' => "Menghapus arsip dokumen: " . $arsip->dokumen->judul_dokumen
        ]);

        // Soft delete (data tidak hilang dari database, hanya ditandai terhapus)
        $arsip->delete();
        // Dokumen aslinya juga bisa ikut di-soft delete jika perlu:
        // $arsip->dokumen()->delete(); 

        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip berhasil dihapus dari sistem!');
    }
}
