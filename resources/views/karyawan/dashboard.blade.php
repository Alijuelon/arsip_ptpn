<x-app-layout>

    <div class="mb-8 border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->nama_user }}.</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan kelola dan pantau dokumen yang Anda unggah ke sistem arsip.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col items-center justify-center text-center hover:border-blue-300 transition">
            <h3 class="text-4xl font-black text-gray-900 mb-2">{{ $uploadBulanIni }}</h3>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Upload Bulan Ini</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col items-center justify-center text-center hover:border-red-300 transition">
            <h3 class="text-4xl font-black text-red-600 mb-2">{{ $ditolakAdmin }}</h3>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Ditolak Admin</p>
        </div>

        <a href="{{ route('karyawan.inbox.index') }}" class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col items-center justify-center text-center hover:border-green-300 transition group block">
            <h3 class="text-4xl font-black text-green-600 mb-2 group-hover:scale-110 transition-transform">{{ $inboxBaru }}</h3>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Dokumen Masuk (Belum Dibaca)</p>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Aktivitas Upload Terakhir</h3>
            <a href="{{ route('karyawan.dokumen.index') }}" class="text-xs font-semibold text-primary hover:text-primary-hover transition">Lihat Semua</a>
        </div>
        <div class="p-6 space-y-4">
            
            @forelse($aktivitasTerbaru as $dokumen)
                <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    
                    @if($dokumen->status_dokumen === 'Menunggu')
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    @elseif($dokumen->status_dokumen === 'Disetujui')
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    @endif

                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $dokumen->judul_dokumen }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            @if($dokumen->status_dokumen === 'Menunggu')
                                Sedang menunggu verifikasi admin
                            @elseif($dokumen->status_dokumen === 'Disetujui')
                                Telah divalidasi dan diarsipkan secara permanen
                            @else
                                Ditolak oleh admin, harap periksa kembali dokumen Anda
                            @endif
                            ({{ \Carbon\Carbon::parse($dokumen->created_at)->diffForHumans() }})
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm font-medium">Anda belum mengunggah dokumen apa pun.</p>
                </div>
            @endforelse

        </div>
    </div>

</x-app-layout>