<x-app-layout>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 border-b border-gray-200 pb-4 gap-4">
        <div class="flex items-center">
            <a href="{{ route('admin.arsip.index') }}" class="mr-4 text-gray-500 hover:text-primary transition bg-white border border-gray-200 p-2 rounded-lg shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Detail Dokumen <span class="text-primary">#ARS-{{ str_pad($arsip->id, 4, '0', STR_PAD_LEFT) }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Divalidasi pada {{ \Carbon\Carbon::parse($arsip->created_at)->format('d F Y') }} oleh {{ $arsip->staffPengarsip->nama_user ?? 'Admin' }}
                </p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="openEditModal()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Metadata Fisik
            </button>
            <button onclick="openDeleteModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Arsip
            </button>
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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Utama Dokumen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-6 text-sm">
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Judul Dokumen</p>
                        <p class="font-bold text-gray-900 text-base">{{ $arsip->dokumen->judul_dokumen }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Kategori Arsip</p>
                        <span class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">
                            {{ $arsip->dokumen->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Tanggal Upload ke Sistem</p>
                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($arsip->dokumen->created_at)->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Lokasi Arsip Fisik (Hardcopy)</p>
                        <p class="font-medium text-gray-800 flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            {{ $arsip->lokasi_arsip ?? 'Belum ditentukan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Pengunggah Asli (Karyawan)</p>
                        <div class="flex items-center mt-1">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold mr-3 border border-blue-200">
                                {{ strtoupper(substr($arsip->dokumen->pengirim->nama_user ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-800 block">{{ $arsip->dokumen->pengirim->nama_user ?? 'Sistem' }}</span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wide">{{ $arsip->dokumen->pengirim->departemen->nama_departemen ?? 'Staff Umum' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500 font-medium mb-2">Keterangan / Catatan Tambahan</p>
                        <div class="text-gray-800 bg-gray-50 p-4 rounded-lg border border-gray-100 leading-relaxed min-h-[80px]">
                            {{ $arsip->dokumen->keterangan ?? 'Tidak ada keterangan tambahan yang disertakan pada dokumen ini.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-green-50 rounded-xl border border-green-200 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10 text-green-600">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="font-bold text-green-900 mb-2 relative z-10">Status Terkini</h3>
                <div class="flex items-center text-green-700 relative z-10">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-black text-xl tracking-tight">Telah Divalidasi</span>
                </div>
                <p class="text-xs text-green-800 font-medium mt-3 relative z-10">
                    Dokumen ini telah sah diarsipkan ke dalam database pusat.
                </p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 text-center">
                <div class="w-20 h-20 mx-auto bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4 border border-red-100 shadow-inner">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                </div>
                
                {{-- Mengekstrak nama file asli dari path --}}
                @php
                    $fileName = basename($arsip->dokumen->file_dokumen);
                @endphp
                
                <p class="font-bold text-gray-900 truncate px-2" title="{{ $fileName }}">{{ $fileName }}</p>
                <p class="text-xs text-gray-500 mt-1 mb-6">File Berkas Resmi</p>
                
                <a href="{{ asset('storage/' . $arsip->dokumen->file_dokumen) }}" target="_blank" class="w-full inline-flex bg-primary hover:bg-primary-hover text-white py-3 rounded-lg text-sm font-bold shadow-md transition justify-center items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Lihat / Unduh Dokumen
                </a>
            </div>
        </div>
    </div>

    {{-- ==========================================
         MODAL EDIT METADATA (LOKASI FISIK)
    =========================================== --}}
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300 flex">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 transform transition-all translate-y-4 duration-300" id="editModalContent">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between rounded-t-xl">
                <h3 class="font-bold text-gray-900">Ubah Lokasi Arsip Fisik</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.arsip.update', $arsip->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Hardcopy Baru <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi_arsip" value="{{ $arsip->lokasi_arsip }}" required placeholder="Contoh: Lemari A-1, Ruang Tata Usaha" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    <p class="text-[10px] text-gray-500 mt-2 leading-relaxed">Pembaruan ini akan dicatat ke dalam riwayat aktivitas sistem sebagai bentuk audit keamanan data arsip.</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white rounded-lg text-sm font-bold shadow-sm transition">
                        Simpan Pembaruan
                    </button>
                </div>
            </form>
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
                    Apakah Anda yakin ingin menghapus <span class="font-bold text-gray-800">"{{ $arsip->dokumen->judul_dokumen }}"</span>? Arsip akan dipindahkan ke tempat sampah.
                </p>
                
                <div class="flex w-full gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <form action="{{ route('admin.arsip.destroy', $arsip->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-md transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');

        function openEditModal() {
            editModal.classList.remove('hidden');
            void editModal.offsetWidth; // trigger reflow
            editModal.classList.remove('opacity-0');
            editModalContent.classList.remove('translate-y-4');
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0');
            editModalContent.classList.add('translate-y-4');
            setTimeout(() => { editModal.classList.add('hidden'); }, 300);
        }

        function openDeleteModal() {
            deleteModal.classList.remove('hidden');
            void deleteModal.offsetWidth;
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('translate-y-4');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0');
            deleteModalContent.classList.add('translate-y-4');
            setTimeout(() => { deleteModal.classList.add('hidden'); }, 300);
        }
    </script>

</x-app-layout>