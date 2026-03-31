<?php
namespace App\Http\Controllers\Pimpinan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;

class SuratDisposisiController extends Controller
{
    public function index()
    {
        // Ambil dokumen yang dikirim oleh Pimpinan yang sedang login
        $suratTerkirim = Dokumen::where('pengirim_id', \Illuminate\Support\Facades\Auth::id())
            ->where('status_dokumen', 'Disposisi')
            ->latest()
            ->paginate(10);

        return view('pimpinan.surat.index', compact('suratTerkirim'));
    }

    // 2. Menghapus / Menarik Surat Disposisi
    public function destroy($id)
    {
        $surat = Dokumen::findOrFail($id);

        // Hapus file fisiknya dari storage agar tidak memenuhi hardisk
        if ($surat->file_dokumen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($surat->file_dokumen);
        }

        // Hapus data dari database
        $surat->delete();

        return back()->with('success', 'Surat disposisi berhasil ditarik dan dihapus dari sistem.');
    }
    public function create()
    {
        // Tampilkan halaman form upload pimpinan
        return view('pimpinan.surat.create');
    }

   public function store(Request $request)
    {
        // Gunakan try-catch agar error database tidak tersembunyi
        try {
            // 1. Validasi Input Manual
            $request->validate([
                'judul_dokumen' => 'required',
            ]);
            // Cek manual apakah ada file yang dikirim
            if (!$request->hasFile('file_dokumen')) {
                return back()->with('error', 'Gagal: Anda belum memilih file, atau ukuran file terlalu besar (Maksimal 2MB untuk server lokal).');
            }

            // 2. Ambil Kategori Dinamis
            $kategoriTersedia = \Illuminate\Support\Facades\DB::table('kategori_dokumens')->first();
            
            if (!$kategoriTersedia) {
                return back()->with('error', 'Gagal: Tabel Kategori Dokumen masih kosong. Minta Admin untuk membuat minimal 1 Kategori.');
            }

            // 3. Simpan File
            $path = $request->file('file_dokumen')->store('surat_pimpinan', 'public');

            // 4. Simpan ke Database
            Dokumen::create([
                'judul_dokumen' => $request->judul_dokumen,
                'kategori_id' => $kategoriTersedia->id,
                'file_dokumen' => $path,
                'pengirim_id' => \Illuminate\Support\Facades\Auth::id(),
                'status_dokumen' => 'Disposisi',
                'keterangan' => $request->keterangan ?? 'Surat instruksi dari Pimpinan'
            ]);

            return back()->with('success', 'Surat dan dokumen berhasil dikirim ke seluruh Staff.');

        } catch (\Exception $e) {
            // Jika database menolak, layar akan menampilkan teks error ini secara jelas!
            dd('SISTEM MENEMUKAN ERROR: ' . $e->getMessage());
        }
    }
}