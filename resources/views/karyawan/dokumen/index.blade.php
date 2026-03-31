<x-app-layout>

    <div class="mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Upload Saya</h2>
        <p class="text-sm text-gray-500 mt-1">Memantau status dokumen yang telah Anda kirimkan untuk diverifikasi oleh Admin.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-start shadow-sm transition">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Berhasil!</h4>
                <p class="text-sm mt-1 text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-gray-800 hidden sm:block">Daftar Dokumen Anda</h3>
            
            <form action="{{ route('karyawan.dokumen.index') }}" method="GET" class="w-full sm:w-auto flex relative">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari berdasarkan judul..." class="w-full sm:w-64 px-4 py-2 pr-10 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white transition">
                <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-primary transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Tanggal Upload</th>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-1/3">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($dokumens as $dokumen)
                        
                        {{-- Mengatur warna baris berdasarkan status dokumen --}}
                        @php
                            $rowClass = 'hover:bg-gray-50 transition';
                            if($dokumen->status_dokumen === 'Ditolak') $rowClass = 'hover:bg-red-50/30 transition bg-red-50/10';
                            if($dokumen->status_dokumen === 'Disetujui') $rowClass = 'hover:bg-green-50/30 transition';
                        @endphp

                        <tr class="{{ $rowClass }}">
                            <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($dokumen->created_at)->format('d-m-Y') }}
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($dokumen->created_at)->format('H:i') }} WIB</span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $dokumen->judul_dokumen }}</p>
                                <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}" target="_blank" class="inline-flex items-center text-xs text-primary hover:text-primary-hover font-medium mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Lihat File Asli
                                </a>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($dokumen->status_dokumen === 'Menunggu')
                                    <span class="bg-gray-800 text-white px-3 py-1 rounded text-[11px] font-bold tracking-wide">PENDING</span>
                                @elseif($dokumen->status_dokumen === 'Disetujui')
                                    <span class="bg-green-100 border border-green-200 text-green-700 px-3 py-1 rounded text-[11px] font-bold tracking-wide">DIARSIPKAN (VALID)</span>
                                @elseif($dokumen->status_dokumen === 'Ditolak')
                                    <span class="bg-red-50 border border-red-500 text-red-600 px-3 py-1 rounded text-[11px] font-bold tracking-wide">DITOLAK</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($dokumen->status_dokumen === 'Menunggu')
                                    <span class="text-gray-400 italic text-xs">Menunggu peninjauan...</span>
                                @else
                                    {{-- Mengambil catatan validasi terbaru jika dokumen sudah ditinjau --}}
                                    @php
                                        $catatanAdmin = $dokumen->validasis->first()->catatan_validasi ?? '-';
                                    @endphp

                                    @if($dokumen->status_dokumen === 'Ditolak')
                                        <p class="text-red-600 font-medium text-xs leading-relaxed">
                                            {{ $catatanAdmin }}
                                        </p>
                                    @else
                                        <p class="text-gray-600 text-xs leading-relaxed">
                                            {{ $catatanAdmin }}
                                        </p>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="font-medium">Belum ada dokumen yang Anda unggah.</p>
                                @if(request('cari'))
                                    <a href="{{ route('karyawan.dokumen.index') }}" class="text-primary hover:underline mt-2 inline-block text-sm">Hapus Pencarian</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $dokumens->withQueryString()->links() }}
        </div>
    </div>

</x-app-layout>