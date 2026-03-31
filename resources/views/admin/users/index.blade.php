<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data hak akses Admin, Karyawan/Staff, dan Pimpinan.</p>
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

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Gagal menyimpan data:</h4>
                <ul class="list-disc list-inside text-sm mt-1 text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
        <h3 class="font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Tambah Pengguna Baru</h3>
        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-start">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_user" value="{{ old('nama_user') }}" required placeholder="Masukkan nama..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">NIP / Username <span class="text-red-500">*</span></label>
                <input type="text" name="nip" value="{{ old('nip') }}" required placeholder="Contoh: 123456" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Valid <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@ptpn4.co.id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Role (Hak Akses) <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                    <option value="Staff" {{ old('role') == 'Staff' ? 'selected' : '' }}>Staff / Karyawan</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Pimpinan" {{ old('role') == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Departemen <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <select name="departemen_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departemens as $dept)
                        <option value="{{ $dept->id }}" {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_departemen }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-3 flex justify-end mt-2">
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-gray-900">Daftar Pengguna Sistem</h3>
            
            <form action="{{ route('admin.users.index') }}" method="GET" class="w-full sm:w-auto flex">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau NIP..." class="px-4 py-2 border border-gray-200 rounded-l-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none w-full sm:w-64 bg-white">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-r-lg text-sm font-bold transition">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">NIP / Email</th>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $user->nama_user }}</td>
                            <td class="px-6 py-4">
                                <span class="text-gray-900 font-medium">{{ $user->nip }}</span><br>
                                <span class="text-gray-500 text-xs">{{ $user->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $user->departemen->nama_departemen ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($user->role === 'Admin')
                                    <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-[11px] font-bold">Admin</span>
                                @elseif($user->role === 'Pimpinan')
                                    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-[11px] font-bold">Pimpinan</span>
                                @else
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-[11px] font-bold">Staff</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->nama_user) }}', '{{ $user->nip }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->departemen_id }}')" class="text-blue-600 hover:text-blue-800 font-medium text-xs mr-3 px-2 py-1 rounded bg-blue-50 border border-blue-100 transition">Edit</button>
                                
                                @if(Auth::id() !== $user->id)
                                    <button onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->nama_user) }}')" class="text-red-600 hover:text-red-800 font-medium text-xs px-2 py-1 rounded bg-red-50 border border-red-100 transition">Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>


    {{-- ==========================================
         MODAL EDIT DATA PENGGUNA
    =========================================== --}}
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300 flex">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl mx-4 transform transition-all translate-y-4 duration-300" id="editModalContent">
            <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between rounded-t-xl">
                <h3 class="font-bold text-gray-900 text-lg">Edit Data Pengguna</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="editForm" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="edit_nama" name="nama_user" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIP / Username</label>
                        <input type="text" id="edit_nip" name="nip" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Valid</label>
                        <input type="email" id="edit_email" name="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role (Hak Akses)</label>
                        <select id="edit_role" name="role" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition text-gray-700">
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff / Karyawan</option>
                            <option value="Pimpinan">Pimpinan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                        <select id="edit_departemen" name="departemen_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                            <option value="">-- Kosong --</option>
                            @foreach($departemens as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white rounded-lg text-sm font-bold shadow-sm transition">
                        Simpan Perubahan
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
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Data Pengguna?</h3>
                <p class="text-sm text-gray-500 mb-6 px-4">
                    Apakah Anda yakin ingin menghapus akun <span id="deleteUserName" class="font-bold text-gray-800"></span>? Data yang dihapus tidak dapat dikembalikan.
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
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');

        function openEditModal(id, nama, nip, email, role, dept_id) {
            // Set Form Action URL dynamically
            document.getElementById('editForm').action = `{{ url('admin/users') }}/${id}`;
            
            // Populate Data
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nip').value = nip;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_departemen').value = dept_id;

            // Show Modal
            editModal.classList.remove('hidden');
            // Trigger reflow
            void editModal.offsetWidth;
            editModal.classList.remove('opacity-0');
            editModalContent.classList.remove('translate-y-4');
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0');
            editModalContent.classList.add('translate-y-4');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300);
        }

        function openDeleteModal(id, nama) {
            document.getElementById('deleteForm').action = `{{ url('admin/users') }}/${id}`;
            document.getElementById('deleteUserName').innerText = `"${nama}"`;
            
            deleteModal.classList.remove('hidden');
            void deleteModal.offsetWidth;
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('translate-y-4');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0');
            deleteModalContent.classList.add('translate-y-4');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        }
    </script>

</x-app-layout>