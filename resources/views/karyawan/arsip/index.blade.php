<x-app-layout>

    <div class="mb-6 flex flex-col lg:flex-row lg:items-end justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-7 h-7 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                Arsip Digital Utama
            </h2>
            <p class="text-sm text-gray-500 mt-1">Akses seluruh dokumen resmi perusahaan yang telah diverifikasi dan diarsipkan.</p>
        </div>
        
        <form action="{{ route('karyawan.arsip.index') }}" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
            <select name="kategori" class="bg-white border border-gray-200 rounded-lg text-sm px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition cursor-pointer text-gray-700">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <button type="submit" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition flex items-center justify-center">
                Terapkan
            </button>
            
            @if(request('search') || request('kategori'))
                <a href="{{ route('karyawan.arsip.index') }}" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Informasi Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 hidden lg:table-cell">Tgl. Arsip</th>
                        <th class="px-6 py-4 text-center w-28">Aksi</th>
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
                                    Oleh: {{ $item->dokumen->pengirim->name ?? 'Sistem/Pusat' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $item->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-sm text-gray-500">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->dokumen && $item->dokumen->file_dokumen)
                                    <button onclick="openDetailModal(
                                        '{{ addslashes($item->dokumen->judul_dokumen) }}',
                                        '{{ addslashes($item->dokumen->kategori->nama_kategori ?? 'Umum') }}',
                                        '{{ addslashes($item->dokumen->pengirim->name ?? 'Sistem') }}',
                                        '{{ addslashes($item->lokasi_arsip ?? 'Arsip Digital') }}',
                                        '{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}',
                                        '{{ addslashes($item->dokumen->keterangan ?? 'Tidak ada keterangan tambahan.') }}',
                                        '{{ route('dokumen.download', $item->dokumen->id) }}'
                                    )" class="inline-flex items-center justify-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-800 px-4 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        Detail
                                    </button>
                                @else
                                    <span class="text-xs text-red-500 font-medium">File hilang</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-gray-500 text-sm font-medium">Tidak ada dokumen yang ditemukan.</p>
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

    {{-- ==========================================
         MODAL DETAIL DOKUMEN & UNDUH
    =========================================== --}}
    <div id="detailModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0" onclick="closeDetailModal()"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 transform transition-all translate-y-4 duration-300 m-auto mt-10 md:mt-20" id="detailModalContent">
            
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-start rounded-t-xl bg-gray-50">
                <div class="pr-8">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1" id="mdlKategori">Kategori</p>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight" id="mdlJudul">Judul Dokumen</h3>
                </div>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-red-500 transition p-1 rounded-md hover:bg-gray-200 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Diunggah Oleh:</p>
                        <div class="flex items-center text-sm font-bold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span id="mdlPengirim">Sistem</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Tanggal Arsip:</p>
                        <div class="flex items-center text-sm font-bold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span id="mdlTanggal">Tanggal</span>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 font-medium mb-1">Lokasi Arsip / Folder Fisik:</p>
                        <div class="flex items-center text-sm font-bold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            <span id="mdlLokasi">Lokasi</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-xs text-gray-500 font-medium mb-2">Keterangan / Catatan Dokumen:</p>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700 leading-relaxed max-h-32 overflow-y-auto custom-scrollbar" id="mdlKeterangan">
                        Keterangan
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeDetailModal()" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition text-center">
                        Tutup
                    </button>
                    
                    <a href="#" id="btnLihatPrint" target="_blank" class="px-5 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-lg text-sm font-bold transition flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat / Print
                    </a>

                    <a href="#" id="btnUnduh" download class="px-5 py-2.5 bg-gray-900 hover:bg-black text-white rounded-lg text-sm font-bold shadow-sm transition flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh File
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const detailModal = document.getElementById('detailModal');
        const detailModalContent = document.getElementById('detailModalContent');

        function openDetailModal(judul, kategori, pengirim, lokasi, tanggal, keterangan, fileUrl) {
            // Isi teks ke dalam modal
            document.getElementById('mdlJudul').innerText = judul;
            document.getElementById('mdlKategori').innerText = kategori;
            document.getElementById('mdlPengirim').innerText = pengirim;
            document.getElementById('mdlLokasi').innerText = lokasi;
            document.getElementById('mdlTanggal').innerText = tanggal;
            document.getElementById('mdlKeterangan').innerText = keterangan;
            
            // Set href untuk tombol Print/Lihat
            document.getElementById('btnLihatPrint').href = fileUrl;
            
            // Set href untuk tombol Unduh (menggunakan atribut HTML5 'download')
            document.getElementById('btnUnduh').href = fileUrl;

            // Tampilkan Modal
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');
            
            setTimeout(() => {
                detailModal.classList.remove('opacity-0');
                detailModalContent.classList.remove('translate-y-4');
            }, 10);
        }

        function closeDetailModal() {
            detailModal.classList.add('opacity-0');
            detailModalContent.classList.add('translate-y-4');
            
            setTimeout(() => { 
                detailModal.classList.add('hidden'); 
                detailModal.classList.remove('flex');
            }, 300);
        }
    </script>

</x-app-layout>