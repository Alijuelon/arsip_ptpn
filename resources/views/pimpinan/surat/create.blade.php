<x-app-layout>

    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center">
            <svg class="w-7 h-7 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            Kirim Surat / Disposisi
        </h2>
        <p class="text-sm text-gray-500 mt-1">Unggah dokumen instruksi, memo, atau surat keputusan. Dokumen ini akan langsung masuk ke Kotak Masuk (Inbox) seluruh Staff.</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
        <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h4 class="text-sm font-bold">Berhasil!</h4>
            <p class="text-sm mt-1 text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
        <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div>
            <h4 class="text-sm font-bold">Gagal mengirim surat:</h4>
            <ul class="list-disc list-inside text-sm mt-1 text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="max-w-4xl mx-auto bg-white rounded-xl border border-gray-200 shadow-sm p-8 mt-6">
        <div class="mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Form Pengiriman Disposisi
            </h3>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah ini untuk mengirimkan surat ke bawahan.</p>
        </div>

        <form action="{{ route('pimpinan.surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Surat / Perihal <span class="text-red-500">*</span></label>
                <input type="text" name="judul_dokumen" value="{{ old('judul_dokumen') }}" required placeholder="Contoh: Surat Tugas Audit Internal, Memo Perubahan Jadwal..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi / Catatan Disposisi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <textarea name="keterangan" rows="3" placeholder="Tuliskan pesan instruksi singkat untuk staff yang menerima surat ini..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">{{ old('keterangan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Surat (Lampiran) <span class="text-red-500">*</span></label>

                <label for="file_upload" id="drop_area" class="mt-1 flex flex-col items-center justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 hover:border-primary transition cursor-pointer group">
                    <div class="space-y-2 text-center" id="file_display">
                        <svg class="mx-auto h-12 w-12 text-primary opacity-70 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center font-medium mt-2">
                            <span class="text-primary group-hover:text-indigo-800 underline">Klik untuk melampirkan file</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format didukung: PDF, DOC, DOCX, ZIP (Maks. 10MB)</p>
                    </div>

                    <div id="file_success" class="hidden text-center">
                        <svg class="mx-auto h-12 w-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-bold text-gray-900" id="file_name_text">Nama File</p>
                        <p class="text-xs text-green-600 mt-1">Lampiran siap dikirim. Klik lagi jika ingin mengganti file.</p>
                    </div>
                </label>

                <input id="file_upload" name="file_dokumen" type="file" required class="hidden" accept=".pdf,.doc,.docx,.zip">
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-primary hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md shadow-primary/30 transition flex items-center transform hover:-translate-y-0.5">
                    Kirim Disposisi ke Staff
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('file_upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const displayArea = document.getElementById('file_display');
            const successArea = document.getElementById('file_success');
            const nameText = document.getElementById('file_name_text');
            const dropArea = document.getElementById('drop_area');

            if (fileName) {
                displayArea.classList.add('hidden');
                successArea.classList.remove('hidden');
                nameText.textContent = fileName;
                dropArea.classList.remove('border-gray-300');
                dropArea.classList.add('border-green-400', 'bg-green-50');
            } else {
                displayArea.classList.remove('hidden');
                successArea.classList.add('hidden');
                dropArea.classList.remove('border-green-400', 'bg-green-50');
                dropArea.classList.add('border-gray-300');
            }
        });
    </script>

</x-app-layout>