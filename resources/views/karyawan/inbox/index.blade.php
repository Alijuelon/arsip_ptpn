<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kotak Masuk Dokumen</h2>
            <p class="text-sm text-gray-500 mt-1">Dokumen dan instruksi disposisi yang dikirimkan kepada Anda.</p>
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

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Dari (Pengirim)</th>
                        <th class="px-6 py-4">Perihal / Judul Dokumen</th>
                        <th class="px-6 py-4">Tanggal Terima</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($suratMasuk as $item)
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mr-3 shrink-0">
                                        {{ substr($item->pengirim->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900">{{ $item->pengirim->name ?? 'Sistem' }}</span>
                                        <span class="block text-[10px] text-gray-500 uppercase mt-0.5">
                                            {{ $item->pengirim->role ?? 'Pimpinan' }} 
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">{{ $item->judul_dokumen ?? 'Tanpa Judul' }}</span>
                                <span class="block text-xs text-gray-500 truncate max-w-xs mt-0.5">
                                    {{ Str::limit($item->keterangan ?? 'Tidak ada instruksi khusus.', 60) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                {{-- Tombol Buka Modal Instruksi --}}
                                <button onclick="openMessageModal('{{ addslashes($item->pengirim->name ?? 'Sistem') }}', '{{ addslashes($item->judul_dokumen ?? '-') }}', '{{ addslashes($item->keterangan ?? 'Tidak ada instruksi.') }}', '{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}', '{{ $item->file_dokumen ? route('dokumen.download', $item->id) : '#' }}')" class="inline-flex items-center justify-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-800 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Buka Disposisi
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium text-gray-700">Kotak masuk kosong.</p>
                                <p class="text-xs mt-1">Belum ada surat disposisi yang dikirimkan oleh Pimpinan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ==========================================
         MODAL BACA PESAN (DISPOSISI)
    =========================================== --}}
    <div id="messageModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0" onclick="closeMessageModal()"></div> <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 transform transition-all translate-y-4 duration-300 m-auto mt-20" id="messageModalContent">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/50 flex justify-between items-start rounded-t-xl">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Instruksi Disposisi
                    </h3>
                    <p class="text-xs text-gray-500 mt-1" id="modalDate">Tgl</p>
                </div>
                <button onclick="closeMessageModal()" class="text-gray-400 hover:text-red-500 transition p-1 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="mb-5">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1.5">Dari Pimpinan:</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold mr-3 shadow-sm" id="modalInitial">A</div>
                        <p class="font-bold text-gray-900 text-base" id="modalSender">Pengirim</p>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1.5">Perihal Dokumen:</p>
                    <p class="text-sm font-bold text-indigo-800 bg-indigo-50 border border-indigo-100 px-3 py-2.5 rounded-lg" id="modalDocTitle">Judul Dokumen</p>
                </div>

                <div class="mb-6">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1.5">Isi Catatan / Instruksi:</p>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-800 leading-relaxed min-h-[100px] whitespace-pre-wrap" id="modalInstruction">
                        Isi pesan
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeMessageModal()" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                        Tutup
                    </button>
                    <a href="#" id="modalDownloadBtn" target="_blank" class="px-5 py-2.5 bg-gray-900 hover:bg-black text-white rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Lampiran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const messageModal = document.getElementById('messageModal');
        const messageModalContent = document.getElementById('messageModalContent');

        function openMessageModal(sender, docTitle, instruction, date, fileUrl) {
            // Memasukkan data ke elemen dalam modal
            document.getElementById('modalSender').innerText = sender;
            document.getElementById('modalInitial').innerText = sender.charAt(0).toUpperCase();
            document.getElementById('modalDocTitle').innerText = docTitle;
            document.getElementById('modalInstruction').innerText = instruction;
            document.getElementById('modalDate').innerText = date;
            
            // Mengatur tombol unduh lampiran
            const downloadBtn = document.getElementById('modalDownloadBtn');
            if(fileUrl !== '#' && fileUrl !== '') {
                downloadBtn.href = fileUrl;
                downloadBtn.classList.remove('hidden');
                downloadBtn.classList.add('flex');
            } else {
                downloadBtn.classList.add('hidden');
                downloadBtn.classList.remove('flex');
            }

            // Menampilkan Modal
            messageModal.classList.remove('hidden');
            messageModal.classList.add('flex'); // Pastikan flex aktif agar konten berada di tengah
            
            // Efek transisi
            setTimeout(() => {
                messageModal.classList.remove('opacity-0');
                messageModalContent.classList.remove('translate-y-4');
            }, 10);
        }

        function closeMessageModal() {
            messageModal.classList.add('opacity-0');
            messageModalContent.classList.add('translate-y-4');
            
            setTimeout(() => { 
                messageModal.classList.add('hidden'); 
                messageModal.classList.remove('flex');
            }, 300);
        }
    </script>

</x-app-layout>