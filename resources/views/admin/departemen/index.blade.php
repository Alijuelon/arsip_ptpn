<x-app-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Master Data Departemen</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola daftar divisi atau departemen yang ada di perusahaan.</p>
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
                <h4 class="text-sm font-bold">Gagal!</h4>
                <p class="text-sm mt-1 text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Periksa kembali isian Anda:</h4>
                <ul class="list-disc list-inside text-sm mt-1 text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit">
            <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Tambah Departemen Baru</h3>
            <form action="{{ route('admin.departemen.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_departemen" value="{{ old('nama_departemen') }}" required placeholder="Contoh: Sumber Daya Manusia" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <textarea name="keterangan" rows="3" placeholder="Deskripsi singkat divisi..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">{{ old('keterangan') }}</textarea>
                </div>
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white py-2.5 rounded-lg text-sm font-bold shadow-sm transition">
                    Simpan Data
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden h-fit">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-900">Daftar Departemen</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4 w-12 text-center">No</th>
                            <th class="px-6 py-4">Departemen & Keterangan</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($departemens as $index => $dept)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $dept->nama_departemen }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate max-w-sm">{{ $dept->keterangan ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openEditModal({{ $dept->id }}, '{{ addslashes($dept->nama_departemen) }}', '{{ addslashes($dept->keterangan) }}')" class="text-blue-600 hover:text-blue-800 font-medium text-xs mr-3 px-2 py-1 rounded bg-blue-50 border border-blue-100 transition">Edit</button>
                                    <button onclick="openDeleteModal({{ $dept->id }}, '{{ addslashes($dept->nama_departemen) }}')" class="text-red-600 hover:text-red-800 font-medium text-xs px-2 py-1 rounded bg-red-50 border border-red-100 transition">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada data departemen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300 flex">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all translate-y-4 duration-300" id="editModalContent">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between rounded-t-xl">
                <h3 class="font-bold text-gray-900">Edit Departemen</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Departemen</label>
                    <input type="text" id="edit_nama" name="nama_departemen" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea id="edit_keterangan" name="keterangan" rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none"></textarea>
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary-hover">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300 flex">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-all translate-y-4 duration-300" id="deleteModalContent">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Departemen?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus <span id="delName" class="font-bold"></span>? Data ini tidak bisa dihapus jika masih ada pengguna terkait.</p>
                <div class="flex gap-2">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 border rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50">Batal</button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, nama, ket) {
            document.getElementById('editForm').action = `{{ url('admin/departemen') }}/${id}`;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_keterangan').value = ket;
            document.getElementById('editModal').classList.remove('hidden');
            setTimeout(() => { document.getElementById('editModal').classList.remove('opacity-0'); document.getElementById('editModalContent').classList.remove('translate-y-4'); }, 10);
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('opacity-0'); document.getElementById('editModalContent').classList.add('translate-y-4');
            setTimeout(() => { document.getElementById('editModal').classList.add('hidden'); }, 300);
        }
        function openDeleteModal(id, nama) {
            document.getElementById('deleteForm').action = `{{ url('admin/departemen') }}/${id}`;
            document.getElementById('delName').innerText = `"${nama}"`;
            document.getElementById('deleteModal').classList.remove('hidden');
            setTimeout(() => { document.getElementById('deleteModal').classList.remove('opacity-0'); document.getElementById('deleteModalContent').classList.remove('translate-y-4'); }, 10);
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('opacity-0'); document.getElementById('deleteModalContent').classList.add('translate-y-4');
            setTimeout(() => { document.getElementById('deleteModal').classList.add('hidden'); }, 300);
        }
    </script>
</x-app-layout>