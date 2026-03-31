<x-app-layout>

    <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center">
            <svg class="w-7 h-7 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Inbox Pusat
        </h2>
        <p class="text-sm text-gray-500 mt-1">Tangkap dan kelola dokumen kiriman dari email perusahaan.</p>
    </div>
    
    <div class="flex flex-col sm:flex-row items-center gap-3">
        
        @if(Auth::user()->google_access_token)
            <div class="bg-green-50 p-3 rounded-xl border border-green-200 shadow-sm flex items-center gap-3 w-full sm:w-auto">
                <div class="text-right flex-1 sm:flex-none">
                    <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Terhubung Sebagai</p>
                    <p class="text-sm font-semibold text-green-800 truncate max-w-[150px] sm:max-w-[200px]" title="{{ Auth::user()->google_email }}">
                        {{ Auth::user()->google_email ?? 'Akun Gmail' }}
                    </p>
                </div>
                <form action="{{ route('google.disconnect') }}" method="POST" onsubmit="return confirm('Yakin ingin memutuskan koneksi Gmail?')">
                    @csrf
                    <button type="submit" class="bg-white hover:bg-red-50 text-red-500 p-2 rounded-lg transition shadow-sm border border-green-100" title="Putuskan Koneksi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('karyawan.google.redirect') }}" class="bg-white p-3 rounded-xl border border-gray-200 hover:border-blue-400 shadow-sm flex items-center gap-3 transition cursor-pointer group w-full sm:w-auto">
                <div class="text-right flex-1 sm:flex-none">
                    <p class="text-[10px] font-bold text-gray-400 group-hover:text-blue-500 uppercase tracking-widest transition">Integrasi Email</p>
                    <p class="text-sm font-semibold text-gray-700 group-hover:text-blue-700 transition">Hubungkan Gmail</p>
                </div>
                <div class="bg-blue-50 text-blue-600 p-2 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z"/></svg>
                </div>
            </a>
        @endif

        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex items-center gap-3 w-full sm:w-auto">
            <div class="text-right flex-1 sm:flex-none">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sumber Email Dipantau</p>
                <p class="text-sm font-semibold text-primary">
                    {{ $emailPusat ?: 'Belum diatur' }}
                </p>
            </div>
            <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-lg transition" title="Ubah Pengaturan Email">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </button>
        </div>
    </div>
</div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="bg-gray-50/80 px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Kotak Masuk Dokumen</span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                @if(Auth::user()->google_access_token)
                    <a href="{{ route('karyawan.email.sync') }}" class="flex items-center text-xs font-bold bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Tarik Email Gmail
                    </a>
                @else
                    <span class="text-[10px] text-red-500 font-medium hidden sm:inline-block">*Hubungkan Gmail untuk tarik otomatis</span>
                @endif

                <button onclick="window.location.reload()" class="text-gray-400 hover:text-primary transition bg-white border border-gray-200 sm:border-transparent sm:bg-transparent p-1.5 rounded-lg" title="Refresh/Perbarui Data">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($emails as $email)
                <div onclick="openEmailModal({{ $email->id }})" class="group flex flex-col sm:flex-row sm:items-center px-4 py-3 cursor-pointer transition-colors gap-2 sm:gap-0 {{ $email->is_read ? 'bg-white hover:bg-gray-50' : 'bg-blue-50/30 hover:bg-blue-50/50' }}">
                    <div class="w-full sm:w-1/4 lg:w-1/5 flex items-center pr-4">
                        @if(!$email->is_read)
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-3 shrink-0"></div>
                        @else
                            <div class="w-2 h-2 bg-transparent mr-3 shrink-0"></div>
                        @endif
                        <span class="truncate text-sm {{ $email->is_read ? 'text-gray-700 font-medium' : 'text-gray-900 font-bold' }}">
                            {{ explode('@', $email->pengirim)[0] }} 
                        </span>
                    </div>

                    <div class="flex-1 truncate pr-4 text-sm flex items-center">
                        <span class="{{ $email->is_read ? 'text-gray-800' : 'text-black font-bold' }}">
                            {{ Str::limit($email->subjek ?: 'Tanpa Subjek', 40) }}
                        </span>
                        <span class="text-gray-400 mx-2 hidden sm:inline">-</span>
                        <span class="text-gray-500 hidden sm:inline">{{ Str::limit($email->isi_pesan, 60) }}</span>
                    </div>

                    <div class="w-full sm:w-24 lg:w-32 flex items-center justify-between sm:justify-end text-xs text-gray-500 font-medium pl-5 sm:pl-0 mt-1 sm:mt-0">
                        @if($email->file_lampiran)
                            <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        @endif
                        {{ \Carbon\Carbon::parse($email->tanggal_terima)->format('d M y') }}
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5M10 12l2.25 1.5M14 12l-2.25 1.5"></path></svg>
                    <p class="text-base font-bold text-gray-900">Kotak Masuk Kosong</p>
                    <p class="text-sm mt-1">Belum ada email atau dokumen yang diterima dari Pusat.</p>
                </div>
            @endforelse
        </div>
    </div>


    {{-- MODAL PENGATURAN --}}
    <div id="settingsModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="settingsModalContent">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Pengaturan Sinkronisasi Email</h3>
                <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('karyawan.email.pengaturan') }}" method="POST" class="p-6">
                @csrf
                <p class="text-sm text-gray-500 mb-4">Masukkan alamat email resmi PTPN IV (Pusat). Sistem hanya akan menangkap dan mengizinkan dokumen yang dikirim dari email ini ke dalam Inbox.</p>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Alamat Email Pusat</label>
                    <input type="email" name="email_pusat" value="{{ $emailPusat !== 'Belum diatur' ? $emailPusat : '' }}" placeholder="contoh: pusat@ptpn4.co.id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/30 transition">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

    {{-- MODAL BACA EMAIL --}}
    <div id="readEmailModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEmailModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 flex flex-col max-h-[90vh] transform scale-95 transition-transform duration-300" id="readEmailModalContent">
            
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-start shrink-0">
                <div class="pr-4">
                    <h3 class="font-bold text-xl text-gray-900 leading-tight mb-1" id="readSubjek">Memuat...</h3>
                    <div class="flex items-center text-sm text-gray-500 flex-wrap gap-2">
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded text-xs font-semibold" id="readPengirim">pengirim</span>
                        <span id="readTanggal">tanggal</span>
                    </div>
                </div>
                <button onclick="closeEmailModal()" class="text-gray-400 hover:text-red-500 bg-gray-50 p-1.5 rounded-lg shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>

            <div class="p-6 overflow-y-auto text-sm text-gray-700 leading-relaxed bg-gray-50/50 flex-1 whitespace-pre-wrap" id="readIsi">Memuat isi pesan...</div>

            <div class="p-6 border-t border-gray-100 bg-white rounded-b-2xl shrink-0">
                <div id="attachmentArea" class="mb-4 hidden">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lampiran Ditemukan:</p>
                    <div class="flex items-center bg-blue-50 border border-blue-100 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-blue-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <div class="flex-1 truncate">
                            <p class="text-sm font-bold text-blue-900 truncate" id="readNamaFile">dokumen.pdf</p>
                            <p class="text-xs text-blue-600">Siap diarsipkan ke sistem</p>
                        </div>
                    </div>
                </div>

                <form id="archiveForm" method="POST" action="">
                    @csrf
                    <button type="submit" id="btnArsipkan" class="w-full flex justify-center items-center px-6 py-3.5 bg-gradient-to-r from-primary to-blue-600 hover:from-primary-hover hover:to-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Pindahkan ke Arsip Utama
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openSettingsModal() {
            document.getElementById('settingsModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('settingsModal').classList.remove('opacity-0');
                document.getElementById('settingsModalContent').classList.remove('scale-95');
            }, 10);
        }
        function closeSettingsModal() {
            document.getElementById('settingsModal').classList.add('opacity-0');
            document.getElementById('settingsModalContent').classList.add('scale-95');
            setTimeout(() => document.getElementById('settingsModal').classList.add('hidden'), 300);
        }

        function openEmailModal(emailId) {
            document.getElementById('readEmailModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('readEmailModal').classList.remove('opacity-0');
                document.getElementById('readEmailModalContent').classList.remove('scale-95');
            }, 10);

            fetch(`/karyawan/inbox-pusat/${emailId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('readSubjek').innerText = data.subjek || 'Tanpa Subjek';
                    document.getElementById('readPengirim').innerText = data.pengirim;
                    document.getElementById('readIsi').innerText = data.isi_pesan || 'Tidak ada pesan teks.';
                    
                    let date = new Date(data.tanggal_terima);
                    document.getElementById('readTanggal').innerText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });

                    let formAction = `{{ url('/karyawan/inbox-pusat/arsipkan') }}/${emailId}`;
                    document.getElementById('archiveForm').action = formAction;

                    if(data.file_lampiran) {
                        document.getElementById('attachmentArea').classList.remove('hidden');
                        document.getElementById('readNamaFile').innerText = data.nama_file || 'Lampiran Dokumen';
                        document.getElementById('btnArsipkan').classList.remove('hidden');
                    } else {
                        document.getElementById('attachmentArea').classList.add('hidden');
                        document.getElementById('btnArsipkan').classList.add('hidden');
                    }
                });
        }

        function closeEmailModal() {
            document.getElementById('readEmailModal').classList.add('opacity-0');
            document.getElementById('readEmailModalContent').classList.add('scale-95');
            setTimeout(() => {
                document.getElementById('readEmailModal').classList.add('hidden');
                window.location.reload();
            }, 300);
        }
    </script>

</x-app-layout>