<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArsipDokumen;
use App\Models\KategoriDokumen;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanArsip;

class LaporanAdminController extends Controller
{
    /**
     * Menampilkan halaman Form Laporan dan Hasil filternya.
     */
    public function index(Request $request)
    {
        $kategoris = KategoriDokumen::all();
        $hasilLaporan = collect(); // Kosong secara default sebelum di-filter

        // Jika user melakukan submit filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'kategori_id' => 'nullable|exists:kategori_dokumens,id'
            ]);

            // PERBAIKAN: Gunakan 'created_at' sebagai pengganti 'tanggal_arsip'
            $query = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim'])
                ->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);

            // Jika filter kategori dipilih
            if ($request->filled('kategori_id')) {
                $query->whereHas('dokumen', function($q) use ($request) {
                    $q->where('kategori_id', $request->kategori_id);
                });
            }

            // PERBAIKAN: Gunakan 'created_at' untuk mengurutkan data
            $hasilLaporan = $query->orderBy('created_at', 'asc')->get();

            // Opsional: Simpan log bahwa laporan pernah di-generate ke database
            if ($hasilLaporan->count() > 0) {
                LaporanArsip::create([
                    'periode' => $request->start_date . ' s/d ' . $request->end_date,
                    'total_dokumen' => $hasilLaporan->count(),
                    'dibuat_oleh' => Auth::id()
                ]);
            }
        }

        return view('admin.laporan.index', compact('kategoris', 'hasilLaporan'));
    }

    /**
     * Fungsi untuk Export PDF (Siapkan ini jika nanti pakai DomPDF)
     */
    public function downloadPdf(Request $request)
    {
        // Logika query sama seperti index()
        // ...

        // Jika pakai DomPDF:
        // $pdf = PDF::loadView('admin.laporan.pdf', compact('hasilLaporan', 'start_date', 'end_date'));
        // return $pdf->download('Laporan_Arsip_PTPN_IV.pdf');
        
        return back()->with('info', 'Fitur download PDF belum diaktifkan (membutuhkan library DomPDF).');
    }
}