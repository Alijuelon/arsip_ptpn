<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Laporan Sistem Arsip</h2>
            <p class="text-sm text-gray-500 mt-1">Buat rekapitulasi jumlah dokumen arsip berdasarkan periode tertentu.</p>
        </div>
    </div>

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Informasi</h4>
                <p class="text-sm mt-1 text-blue-700">{{ session('info') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
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

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 lg:p-8 mb-8">
        <div class="text-center mb-6 border-b border-gray-100 pb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 mb-4 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Parameter Laporan</h3>
            <p class="text-sm text-gray-500 mt-1">Tentukan rentang tanggal untuk melihat rekapitulasi data arsip.</p>
        </div>

        <form action="{{ route('admin.laporan.index') }}" method="GET" class="max-w-4xl mx-auto space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Awal <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Akhir <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Kategori <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <select name="kategori_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none text-gray-700 transition cursor-pointer">
                    <option value="">-- Semua Kategori Dokumen --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit" class="sm:w-1/3 bg-primary hover:bg-primary-hover text-white py-3 rounded-xl text-sm font-bold shadow-sm transition flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Tampilkan Laporan
                </button>
                
                @if(request('start_date'))
                    <a href="{{ route('admin.laporan.index') }}" class="sm:w-1/4 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-xl text-sm font-bold shadow-sm transition flex items-center justify-center">
                        Reset Filter
                    </a>
                @endif

                </div>
        </form>
    </div>

    @if(request('start_date') && request('end_date'))
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-bold text-gray-900">Hasil Laporan Arsip</h3>
                    <p class="text-xs text-gray-500 mt-1">Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} s/d {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</p>
                </div>
                <div class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold">
                    Total: {{ $hasilLaporan->count() }} Dokumen
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4 w-16 text-center">No</th>
                            <th class="px-6 py-4">Tgl Arsip</th>
                            <th class="px-6 py-4">Judul Dokumen</th>
                            <th class="px-6 py-4 text-center">Kategori</th>
                            <th class="px-6 py-4">Pengirim / Dept</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($hasilLaporan as $index => $arsip)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($arsip->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $arsip->dokumen->judul_dokumen }}</p>
                                    <p class="text-[10px] text-gray-400 font-mono mt-0.5">ID: ARS-{{ str_pad($arsip->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full text-[11px] font-bold">
                                        {{ $arsip->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $arsip->dokumen->pengirim->nama_user ?? 'Tidak Dikenal' }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-wide mt-0.5">{{ $arsip->dokumen->pengirim->departemen->nama_departemen ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="font-medium">Tidak ada data arsip yang ditemukan pada rentang tanggal tersebut.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</x-app-layout>