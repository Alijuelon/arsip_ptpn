<x-app-layout>

    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Upload Dokumen Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Kirimkan dokumen operasional Anda untuk diverifikasi dan diarsipkan ke pusat.</p>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
        <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h4 class="text-sm font-bold">Terjadi Kesalahan!</h4>
            <p class="text-sm mt-1 text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
        <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div>
            <h4 class="text-sm font-bold">Gagal mengunggah dokumen:</h4>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Form Pengunggahan Dokumen
            </h3>
            <p class="text-sm text-gray-500 mt-1">Pastikan file yang diunggah valid dan ukurannya tidak melebihi batas.</p>
        </div>

        <form action="{{ route('karyawan.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_dokumen" value="{{ old('judul_dokumen') }}" required placeholder="Masukkan judul..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-xs text-primary font-normal ml-2">(Sistem akan deteksi otomatis jika dikosongkan)</span></label>
                    <select name="kategori_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition cursor-pointer text-gray-700">
                        <option value="">-- Biarkan Kosong (Auto-Detect) --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }} ({{ $kategori->kode_kategori }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <textarea name="keterangan" rows="3" placeholder="Berikan catatan, ringkasan, atau keterangan untuk admin yang memverifikasi..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">{{ old('keterangan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File <span class="text-red-500">*</span></label>

                <label for="file_upload" id="drop_area" class="mt-1 flex flex-col items-center justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 hover:border-primary transition cursor-pointer group">
                    <div class="space-y-2 text-center" id="file_display">
                        <svg class="mx-auto h-12 w-12 text-primary opacity-70 group-hover:scale-110 transition-transform" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center font-medium mt-2">
                            <span class="text-primary group-hover:text-indigo-800 underline">Klik untuk pilih file</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format didukung: PDF, DOC, DOCX, ZIP (Maks. 10MB)</p>
                    </div>

                    <div id="file_success" class="hidden text-center">
                        <svg class="mx-auto h-12 w-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-bold text-gray-900" id="file_name_text">Nama File</p>
                        <p class="text-xs text-green-600 mt-1">File siap diunggah. Klik lagi jika ingin mengganti.</p>
                    </div>
                </label>

                <input id="file_upload" name="file_dokumen" type="file" required class="hidden" accept=".pdf,.doc,.docx,.zip">
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md transition flex items-center">
                    Kirim & Upload Dokumen
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
                // Sembunyikan ikon upload default
                displayArea.classList.add('hidden');
                // Tampilkan ikon sukses dan nama file
                successArea.classList.remove('hidden');
                nameText.textContent = fileName;
                // Ubah border menjadi hijau (menandakan sukses pilih file)
                dropArea.classList.remove('border-gray-300');
                dropArea.classList.add('border-green-400', 'bg-green-50');
            } else {
                // Kembalikan seperti semula jika file dibatalkan
                displayArea.classList.remove('hidden');
                successArea.classList.add('hidden');
                dropArea.classList.remove('border-green-400', 'bg-green-50');
                dropArea.classList.add('border-gray-300');
            }
        });
    </script>

</x-app-layout>