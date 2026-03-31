<x-app-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Dokumen Masuk</h2>
        <p class="text-sm text-gray-500 mt-1">Periksa dan validasi dokumen yang baru diunggah oleh karyawan.</p>
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

    @if($dokumenPending->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Perhatian</h4>
                <p class="text-sm mt-1 text-yellow-700">Terdapat <span class="font-bold">{{ $dokumenPending->count() }} dokumen</span> yang membutuhkan verifikasi segera. Harap periksa keabsahan dokumen sebelum menyetujui.</p>
            </div>
        </div>
    @else
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-start shadow-sm">
            <svg class="w-5 h-5 mt-0.5 mr-3 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <h4 class="text-sm font-bold">Semua Bersih!</h4>
                <p class="text-sm mt-1 text-green-700">Tidak ada dokumen yang mengantre untuk diverifikasi saat ini.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <div class="xl:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden h-fit">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Daftar Tunggu Verifikasi</h3>
                <span class="text-xs text-gray-500 font-medium">Klik pada baris untuk meninjau dokumen</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Informasi Dokumen</th>
                            <th class="px-6 py-4">Pengirim</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        
                        @forelse($dokumenPending as $doc)
                            {{-- Fungsi onClick akan mengirim data ke form di sebelah kanan --}}
                            <tr onclick="pilihDokumen('{{ $doc->id }}', '{{ addslashes($doc->judul_dokumen) }}', '{{ $doc->file_dokumen }}', '{{ $doc->keterangan }}')" 
                                class="hover:bg-indigo-50/60 transition cursor-pointer group">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 group-hover:text-primary transition">{{ $doc->judul_dokumen }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y, H:i') }} WIB</p>
                                    <span class="inline-block mt-1 text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded font-semibold">{{ $doc->kategori->nama_kategori ?? 'Umum' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $doc->pengirim->nama_user ?? 'Tidak Dikenal' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5 uppercase">{{ $doc->pengirim->departemen->nama_departemen ?? 'Staf' }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-md text-[11px] font-bold tracking-wide">PENDING</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-primary hover:text-primary-hover font-semibold text-xs flex items-center justify-center w-full">
                                        Tinjau <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Antrean dokumen bersih. Anda bisa bersantai.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit relative">
            
            <div id="empty-state" class="absolute inset-0 bg-white/95 z-10 flex flex-col items-center justify-center text-center p-6 rounded-xl border border-dashed border-gray-300 m-4">
                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                <p class="text-sm font-semibold text-gray-600">Pilih dokumen di sebelah kiri</p>
                <p class="text-xs text-gray-400 mt-1">Klik salah satu baris tabel untuk mulai memverifikasi dokumen.</p>
            </div>

            <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Form Validasi Dokumen</h3>
            
            <div class="mb-5 p-4 bg-indigo-50/50 rounded-lg border border-indigo-100">
                <p class="text-[10px] text-gray-500 font-bold mb-1 uppercase tracking-wider">Judul Dokumen Terpilih:</p>
                <p id="doc-title" class="text-sm font-bold text-gray-900 mb-3">-</p>

                <p class="text-[10px] text-gray-500 font-bold mb-1 uppercase tracking-wider">Catatan Pengirim:</p>
                <p id="doc-notes" class="text-xs text-gray-700 italic mb-3 bg-white p-2 border border-gray-200 rounded">-</p>

                <p class="text-[10px] text-gray-500 font-bold mb-1 uppercase tracking-wider">File Tersisip:</p>
                <a id="doc-file-link" href="#" target="_blank" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-hover bg-white px-3 py-1.5 border border-indigo-200 rounded transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Lihat File Dokumen
                </a>
            </div>

            <form id="form-validasi" action="" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keputusan Validasi <span class="text-red-500">*</span></label>
                    <select id="status_validasi" name="status_validasi" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition cursor-pointer">
                        <option value="">-- Tentukan Keputusan --</option>
                        <option value="Disetujui">Disetujui & Diarsipkan (Permanen)</option>
                        <option value="Ditolak">Ditolak (Kembalikan ke Karyawan)</option>
                    </select>
                </div>

                <div id="area_lokasi_arsip" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Arsip Fisik <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                    <input type="text" name="lokasi_arsip" placeholder="Contoh: Lemari A-1, Rak B" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition">
                    <p class="text-[10px] text-gray-500 mt-1">Isi jika hardcopy/berkas fisik juga disimpan.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Validasi Admin <span class="text-red-500">*</span></label>
                    <textarea name="catatan_validasi" rows="3" required placeholder="Berikan alasan spesifik jika ditolak, atau pesan konfirmasi jika disetujui..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-primary-light focus:border-primary outline-none transition"></textarea>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded-lg text-sm font-bold shadow-md transition flex justify-center items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Keputusan
                </button>
            </form>
        </div>

    </div>  

    <script>
        // Data URL dasar untuk form action (Laravel Route)
        const baseUrl = "{{ url('admin/verifikasi') }}";

        // Fungsi saat baris tabel diklik
        function pilihDokumen(id, judul, file, keterangan) {
            // Sembunyikan empty state (Tampilan kosong)
            document.getElementById('empty-state').classList.add('hidden');

            // Set data metadata dokumen ke UI
            document.getElementById('doc-title').innerText = judul;
            document.getElementById('doc-notes').innerText = keterangan ? keterangan : "Tidak ada catatan pengirim.";
            
            // Set link file (Asumsi file disimpan di folder storage/app/public/)
            // Jika Anda pakai storage link, ubah path di bawah sesuai sistem Anda:
            document.getElementById('doc-file-link').href = "{{ asset('storage/') }}/" + file;

            // Update action URL form sesuai dengan ID dokumen yang dipilih
            document.getElementById('form-validasi').action = baseUrl + "/" + id;
        }

        // Fungsi untuk menampilkan/menyembunyikan input lokasi arsip fisik
        document.getElementById('status_validasi').addEventListener('change', function() {
            const areaLokasi = document.getElementById('area_lokasi_arsip');
            if(this.value === 'Disetujui') {
                areaLokasi.classList.remove('hidden');
                // Tambahkan sedikit animasi fadeIn (opsional)
                areaLokasi.classList.add('animate-pulse');
                setTimeout(() => areaLokasi.classList.remove('animate-pulse'), 500);
            } else {
                areaLokasi.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>