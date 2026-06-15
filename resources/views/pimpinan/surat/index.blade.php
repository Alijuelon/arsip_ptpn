<x-app-layout>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Disposisi Terkirim</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar surat instruksi dan dokumen yang telah Anda kirimkan ke Staff.</p>
        </div>
        <a href="{{ route('pimpinan.surat.create') }}" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center shrink-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Kirim Surat Baru
        </a>
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
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Perihal / Judul Surat</th>
                        <th class="px-6 py-4">Instruksi / Catatan</th>
                        <th class="px-6 py-4">Tanggal Kirim</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($suratTerkirim as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 text-center text-gray-500 font-medium">
                                {{ ($suratTerkirim->currentPage() - 1) * $suratTerkirim->perPage() + $loop->iteration }}
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">{{ $item->judul_dokumen }}</span>
                                <span class="block text-[10px] text-gray-400 mt-1 uppercase tracking-widest">
                                    Status: Terkirim ke Staff
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="text-gray-600 truncate max-w-xs block">
                                    {{ Str::limit($item->keterangan ?? 'Tidak ada instruksi.', 50) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ $item->created_at->format('d M Y') }}
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ $item->created_at->format('H:i') }} WIB</span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Lihat Detail (Buka Modal) --}}
                                    <button onclick="openPreviewModal(
                                        '{{ addslashes($item->judul_dokumen) }}',
                                        '{{ addslashes($item->keterangan ?? 'Tidak ada instruksi tambahan.') }}',
                                        '{{ $item->created_at->format('d M Y, H:i') }}',
                                        '{{ route('dokumen.download', $item->id) }}'
                                    )" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Lihat Detail & Dokumen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    {{-- Tombol Hapus (Tarik Surat) --}}
                                    <form action="{{ route('pimpinan.surat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menarik dan menghapus surat ini? Surat akan hilang dari kotak masuk Staff.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition" title="Tarik/Hapus Surat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium">Belum ada surat yang dikirim.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $suratTerkirim->links() }}
        </div>
    </div>

    {{-- ==========================================
         MODAL PREVIEW DETAIL SURAT PIMPINAN
    =========================================== --}}
    <div id="previewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm items-center justify-center z-[100] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0" onclick="closePreviewModal()"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 transform transition-all translate-y-4 duration-300" id="previewModalContent">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-start rounded-t-xl">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Detail Surat Terkirim
                    </h3>
                    <p class="text-xs text-gray-500 mt-1" id="mdlTgl">Tgl Kirim</p>
                </div>
                <button onclick="closePreviewModal()" class="text-gray-400 hover:text-red-500 transition p-1 rounded-md hover:bg-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="mb-5">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1.5">Perihal / Judul Surat:</p>
                    <p class="text-sm font-bold text-gray-900 bg-gray-50 border border-gray-200 px-3 py-2.5 rounded-lg" id="mdlJudul">Judul</p>
                </div>

                <div class="mb-6">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1.5">Isi Instruksi Disposisi:</p>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-800 leading-relaxed min-h-[100px] whitespace-pre-wrap" id="mdlInstruksi">
                        Instruksi
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closePreviewModal()" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                        Tutup
                    </button>
                    <a href="#" id="btnLihatDokumen" target="_blank" class="px-5 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Dokumen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const previewModal = document.getElementById('previewModal');
        const previewModalContent = document.getElementById('previewModalContent');

        function openPreviewModal(judul, instruksi, tanggal, fileUrl) {
            document.getElementById('mdlJudul').innerText = judul;
            document.getElementById('mdlInstruksi').innerText = instruksi;
            document.getElementById('mdlTgl').innerText = 'Dikirim pada: ' + tanggal;
            
            // Set link dokumen
            const btnLihat = document.getElementById('btnLihatDokumen');
            if(fileUrl !== '#' && fileUrl !== '') {
                btnLihat.href = fileUrl;
                btnLihat.classList.remove('hidden');
                btnLihat.classList.add('flex');
            } else {
                btnLihat.classList.add('hidden');
                btnLihat.classList.remove('flex');
            }

            // Animasi Buka Modal
            previewModal.classList.remove('hidden');
            previewModal.classList.add('flex');
            
            setTimeout(() => {
                previewModal.classList.remove('opacity-0');
                previewModalContent.classList.remove('translate-y-4');
            }, 10);
        }

        function closePreviewModal() {
            previewModal.classList.add('opacity-0');
            previewModalContent.classList.add('translate-y-4');
            
            setTimeout(() => { 
                previewModal.classList.add('hidden'); 
                previewModal.classList.remove('flex');
            }, 300);
        }
    </script>

</x-app-layout>