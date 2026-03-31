 {{-- ==========================================
         MODAL POP-UP UPDATE PROFIL (ANIMASI MODERN)
    =========================================== --}}
    <div id="profileModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeProfileModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform scale-95 transition-transform duration-300 ease-out" id="profileModalContent">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50/50 flex justify-between items-center rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Pengaturan Profil</h3>
                </div>
                <button onclick="closeProfileModal()" class="text-gray-400 hover:text-red-500 bg-white rounded-full p-1 border border-gray-200 shadow-sm transition transform hover:rotate-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama_user" value="{{ Auth::user()->nama_user }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">NIP (Username)</label>
                        <input type="text" name="nip" value="{{ Auth::user()->nip }}" required class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 outline-none cursor-not-allowed" readonly title="NIP Pegawai tidak dapat diubah">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Akses</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition">
                    </div>
                </div>

                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center"><span class="bg-white px-3 text-xs font-medium text-gray-500">Ubah Keamanan</span></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Password Baru</label>
                        <input type="password" name="password" placeholder="Isi jika ingin diubah" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition">
                    </div>
                </div>

                <div class="pt-5 mt-2 flex justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="closeProfileModal()" class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 hover:bg-primary-hover hover:shadow-primary/50 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
