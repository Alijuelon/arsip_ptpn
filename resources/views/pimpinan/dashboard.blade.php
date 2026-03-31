<x-app-layout>

    <div class="mb-8 border-b border-gray-200 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Executive Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang, <span class="font-bold text-gray-700">{{ Auth::user()->nama_user }}</span>. Berikut adalah ringkasan lalu lintas arsip PTPN IV.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Sistem</p>
            <p class="text-sm font-semibold text-primary">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl border border-blue-700 p-6 shadow-lg text-white relative overflow-hidden flex flex-col justify-between h-40">
            <div class="absolute -right-6 -top-6 opacity-20">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <p class="text-blue-100 font-medium uppercase tracking-wider text-xs">Total Arsip Aktif</p>
                <div class="bg-blue-500/50 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
            </div>
            <h3 class="relative z-10 text-5xl font-black mt-2">{{ number_format($totalArsip) }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between h-40">
            <div class="flex items-center justify-between">
                <p class="text-gray-500 font-semibold text-sm">Antrean Verifikasi Admin</p>
                <div class="bg-yellow-100 text-yellow-600 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            </div>
            <div>
                <h3 class="text-4xl font-black text-gray-900">{{ number_format($dokumenPending) }}</h3>
                <p class="text-xs text-gray-400 mt-1">Dokumen tertahan di meja admin</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between h-40">
            <div class="flex items-center justify-between">
                <p class="text-gray-500 font-semibold text-sm">Karyawan / Staff Aktif</p>
                <div class="bg-purple-100 text-purple-600 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
            </div>
            <div>
                <h3 class="text-4xl font-black text-gray-900">{{ number_format($totalKaryawan) }}</h3>
                <p class="text-xs text-gray-400 mt-1">Pengguna sistem pengarsipan</p>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-900">Arsip Permanen Terbaru</h3>
                <p class="text-xs text-gray-500 mt-0.5">5 Dokumen terakhir yang berhasil diverifikasi dan diarsipkan.</p>
            </div>
            <a href="{{ route('pimpinan.laporan.index') }}" class="text-sm font-semibold text-primary hover:text-primary-hover flex items-center transition">
                Lihat Laporan Lengkap <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">No. Arsip</th>
                        <th class="px-6 py-4">Informasi Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Pengunggah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($arsipTerbaru as $arsip)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-gray-700 font-bold bg-gray-100 px-2.5 py-1 rounded border border-gray-200">
                                    ARS-{{ str_pad($arsip->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-base">{{ $arsip->dokumen->judul_dokumen }}</p>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Diarsipkan: {{ \Carbon\Carbon::parse($arsip->created_at)->format('d M Y') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-700 border border-blue-100 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $arsip->dokumen->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $arsip->dokumen->pengirim->nama_user ?? 'Tidak Diketahui' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase tracking-wide mt-0.5">{{ $arsip->dokumen->pengirim->departemen->nama_departemen ?? '-' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium">Belum ada data arsip di dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>