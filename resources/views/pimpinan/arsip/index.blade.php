<x-app-layout>

    <div class="mb-6 flex flex-col lg:flex-row lg:items-end justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-7 h-7 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Kelola Arsip Pusat (Executive)
            </h2>
            <p class="text-sm text-gray-500 mt-1">Pantau dan kelola seluruh dokumen perusahaan. Anda memiliki hak akses penuh.</p>
        </div>
        
        <form action="{{ route('pimpinan.arsip.index') }}" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
            <select name="kategori" class="bg-white border border-gray-200 rounded-lg text-sm px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition cursor-pointer text-gray-700">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <button type="submit" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition flex items-center justify-center">
                Cari
            </button>
            
            @if(request('search') || request('kategori'))
                <a href="{{ route('pimpinan.arsip.index') }}" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Berhasil!</h4>
                <p class="text-sm mt-1 text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Informasi Dokumen</th>
                        <th class="px-6 py-4">Kategori & Lokasi</th>
                        <th class="px-6 py-4 hidden lg:table-cell">Tgl. Arsip</th>
                        <th class="px-6 py-4 text-center">Aksi (Full Access)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($arsip as $item)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-6 py-4 text-center text-sm text-gray-500 font-medium">
                                {{ ($arsip->currentPage() - 1) * $arsip->perPage() + $loop->iteration }}
                            </td>
                            
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-900 line-clamp-2" title="{{ $item->dokumen->judul_dokumen ?? 'Tanpa Judul' }}">
                                    {{ $item->dokumen->judul_dokumen ?? 'Tanpa Judul' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Pengirim: {{ $item->dokumen->pengirim->name ?? 'Sistem/Pusat' }}
                                </p>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 mb-1">
                                    {{ $item->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <div class="flex items-center text-xs text-gray-500 font-medium">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    {{ $item->lokasi_arsip ?? 'Arsip Digital' }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 hidden lg:table-cell text-sm text-gray-500 font-medium">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Lihat/Unduh (Biru) --}}
                                    <a href="{{ route('dokumen.download', $item->dokumen->id) }}" target="_blank" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Lihat/Unduh Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    {{-- Tombol Edit (Kuning) --}}
                                    {{-- Aktifkan rute edit ini jika Anda sudah membuat form edit Arsip untuk Pimpinan/Admin --}}
                                    {{-- Tombol Hapus (Merah) --}}
                                    <form action="{{ route('pimpinan.arsip.destroy', $item->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Anda akan menghapus dokumen ini secara permanen dari sistem beserta file aslinya. Lanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus Arsip Permanen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-gray-500 text-sm font-medium">Tidak ada dokumen di Arsip Pusat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $arsip->withQueryString()->links() }}
        </div> 
    </div>

</x-app-layout>