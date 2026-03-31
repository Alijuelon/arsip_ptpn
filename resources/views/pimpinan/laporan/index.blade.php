<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Rekapitulasi Arsip</h2>
            <p class="text-sm text-gray-500 mt-1">Tarik data laporan arsip dokumen perusahaan berdasarkan periode waktu.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm print:hidden">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Gagal memproses filter:</h4>
                <ul class="list-disc list-inside text-sm mt-1 text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 lg:p-8 mb-8 print:hidden">
        <form action="{{ route('pimpinan.laporan.index') }}" method="GET" class="max-w-4xl mx-auto space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Dokumen <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <select name="kategori_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition cursor-pointer">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit" class="sm:w-1/3 bg-gray-900 hover:bg-black text-white py-3 rounded-xl text-sm font-bold shadow-sm transition flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Proses Laporan
                </button>
                
                @if(request('start_date'))
                    <a href="{{ route('pimpinan.laporan.index') }}" class="sm:w-1/4 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-xl text-sm font-bold shadow-sm transition flex items-center justify-center">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if(request('start_date') && request('end_date'))
        
        <div class="hidden print:block text-center mb-8 border-b-2 border-gray-800 pb-4">
            <h1 class="text-2xl font-black text-black uppercase tracking-widest">PTPN IV REGIONAL III</h1>
            <h2 class="text-lg font-bold text-gray-800 mt-1">Laporan Rekapitulasi Dokumen Arsip</h2>
            <p class="text-sm text-gray-600 mt-2">Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8 print:border-none print:shadow-none print:rounded-none">
            
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
                <div>
                    <h3 class="font-bold text-gray-900">Hasil Rekapitulasi</h3>
                    <p class="text-xs text-gray-500 mt-1">Menampilkan data arsip dari tanggal yang dipilih.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold">
                        Total: {{ $hasilLaporan->count() }} Dokumen
                    </div>
                    <button onclick="window.print()" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                        Cetak Laporan / PDF
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto print:overflow-visible">
                <table class="w-full text-left border-collapse print:border print:border-gray-800">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider print:bg-gray-100 print:text-black print:border-gray-800">
                            <th class="px-6 py-4 w-12 text-center print:border print:border-gray-800">No</th>
                            <th class="px-6 py-4 print:border print:border-gray-800">No. Arsip</th>
                            <th class="px-6 py-4 print:border print:border-gray-800">Judul Dokumen</th>
                            <th class="px-6 py-4 text-center print:border print:border-gray-800">Kategori</th>
                            <th class="px-6 py-4 print:border print:border-gray-800">Diarsipkan Pada</th>
                            <th class="px-6 py-4 print:border print:border-gray-800">Pengirim (Asal)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm print:divide-gray-800">
                        @forelse($hasilLaporan as $index => $arsip)
                            <tr class="hover:bg-gray-50 transition print:hover:bg-transparent">
                                <td class="px-6 py-4 text-center text-gray-500 font-medium print:border print:border-gray-800">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-mono text-gray-700 print:border print:border-gray-800">
                                    ARS-{{ str_pad($arsip->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 print:border print:border-gray-800">
                                    <p class="font-bold text-gray-900">{{ $arsip->dokumen->judul_dokumen }}</p>
                                </td>
                                <td class="px-6 py-4 text-center print:border print:border-gray-800">
                                    <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full text-[11px] font-bold print:bg-transparent print:text-black print:p-0">
                                        {{ $arsip->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium print:border print:border-gray-800">
                                    {{ \Carbon\Carbon::parse($arsip->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 print:border print:border-gray-800">
                                    <p class="font-bold text-gray-900">{{ $arsip->dokumen->pengirim->nama_user ?? 'Tidak Diketahui' }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase mt-0.5 print:text-black">{{ $arsip->dokumen->pengirim->departemen->nama_departemen ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 print:border print:border-gray-800">
                                    Tidak ada data arsip pada rentang waktu tersebut.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="hidden print:flex justify-end mt-16 pr-12 text-center text-black">
                <div>
                    <p class="mb-20">Mengetahui,</p>
                    <p class="font-bold underline">{{ Auth::user()->nama_user }}</p>
                    <p class="text-sm">Pimpinan PTPN IV</p>
                </div>
            </div>

        </div>
    @endif

</x-app-layout>

{{-- Tambahkan Style khusus Print agar sidebar dan navbar hilang saat dicetak --}}
<style type="text/css">
    @media print {
        /* Sembunyikan Sidebar & Navbar bawaan App Layout */
        aside, nav, header {
            display: none !important;
        }
        /* Buat konten menjadi full width saat di print */
        main {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        body {
            background-color: white !important;
        }
    }
</style>