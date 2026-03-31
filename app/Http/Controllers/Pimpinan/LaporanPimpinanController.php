<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArsipDokumen;
use App\Models\KategoriDokumen;

class LaporanPimpinanController extends Controller
{
    /**
     * Menampilkan halaman filter laporan dan hasil rekapitulasi.
     */
    public function index(Request $request)
    {
        $kategoris = KategoriDokumen::all();
        $hasilLaporan = collect(); // Koleksi kosong secara default

        // Jika form filter disubmit
        if ($request->has('start_date') && $request->has('end_date')) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'kategori_id' => 'nullable|exists:kategori_dokumens,id'
            ]);

            // Query pencarian berdasarkan rentang waktu arsip dibuat (created_at)
            $query = ArsipDokumen::with(['dokumen.kategori', 'dokumen.pengirim.departemen'])
                ->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);

            // Jika Pimpinan memfilter spesifik berdasarkan kategori tertentu
            if ($request->filled('kategori_id')) {
                $query->whereHas('dokumen', function($q) use ($request) {
                    $q->where('kategori_id', $request->kategori_id);
                });
            }

            // Dapatkan hasil dan urutkan dari yang paling lama ke terbaru
            $hasilLaporan = $query->orderBy('created_at', 'asc')->get();
        }

        return view('pimpinan.laporan.index', compact('kategoris', 'hasilLaporan'));
    }
}