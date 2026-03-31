<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Arsip Utama</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh dokumen yang telah divalidasi dan disimpan secara permanen.</p>
        </div>
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

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Terjadi Kesalahan!</h4>
                <p class="text-sm mt-1 text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.arsip.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul dokumen..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white transition">
                    </div>
                </div>

                <div class="md:w-1/3">
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white transition cursor-pointer text-gray-700">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                        Filter Data
                    </button>
                    @if(request('cari') || request('kategori'))
                        <a href="{{ route('admin.arsip.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">No. Arsip</th>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4 text-center">Kategori</th>
                        <th class="px-6 py-4">Lokasi Fisik</th>
                        <th class="px-6 py-4">Tgl Arsip</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($arsips as $arsip)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-gray-600 font-bold bg-gray-100 px-2 py-1 rounded text-xs border border-gray-200">
                                    ARS-{{ str_pad($arsip->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $arsip->dokumen->judul_dokumen ?? 'Dokumen Tidak Ditemukan' }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 uppercase tracking-wide">Oleh: {{ $arsip->dokumen->pengirim->nama_user ?? 'Sistem' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 border border-blue-100 text-blue-700 px-2.5 py-1 rounded text-xs font-bold">
                                    {{ $arsip->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($arsip->lokasi_arsip && $arsip->lokasi_arsip !== 'Belum ditentukan')
                                    <span class="text-gray-800 font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        {{ $arsip->lokasi_arsip }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic text-xs">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($arsip->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.arsip.show', $arsip->id) }}" class="inline-block text-primary hover:text-primary-hover font-medium text-xs mr-2 px-3 py-1.5 rounded bg-indigo-50 border border-indigo-100 transition shadow-sm">
                                    Detail
                                </a>
                                <button onclick="openDeleteModal({{ $arsip->id }}, '{{ addslashes($arsip->dokumen->judul_dokumen ?? 'Arsip ini') }}')" class="text-red-600 hover:text-red-800 font-medium text-xs px-3 py-1.5 rounded bg-red-50 border border-red-100 transition shadow-sm">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium">Belum ada data arsip yang tersimpan atau ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $arsips->withQueryString()->links() }}
        </div>
    </div>

    {{-- ==========================================
         MODAL KONFIRMASI HAPUS
    =========================================== --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300 flex">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all translate-y-4 duration-300" id="deleteModalContent">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4 shadow-inner">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Arsip Permanen?</h3>
                <p class="text-sm text-gray-500 mb-6 px-4">
                    Apakah Anda yakin ingin menghapus <span id="deleteDocName" class="font-bold text-gray-800"></span>? Data ini akan dipindahkan ke tempat sampah (Soft Delete).
                </p>
                
                <div class="flex w-full gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-md transition">
                            Ya, Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');

        function openDeleteModal(id, title) {
            // Setup Form action URL dinamis berdasarkan ID
            document.getElementById('deleteForm').action = `{{ url('admin/arsip') }}/${id}`;
            document.getElementById('deleteDocName').innerText = `"${title}"`;
            
            // Tampilkan Modal
            deleteModal.classList.remove('hidden');
            void deleteModal.offsetWidth; // trigger reflow
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('translate-y-4');
        }

        function closeDeleteModal() {
            // Sembunyikan dengan animasi
            deleteModal.classList.add('opacity-0');
            deleteModalContent.classList.add('translate-y-4');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        }
    </script>

</x-app-layout>