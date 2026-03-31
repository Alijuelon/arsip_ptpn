<x-app-layout>
    
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-8 flex items-start">
        <svg class="w-5 h-5 text-primary mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <h4 class="text-sm font-bold text-indigo-900">Selamat datang kembali, {{ Auth::user()->nama_user }}!</h4>
            <p class="text-sm text-indigo-700 mt-1">Anda login sebagai {{ Auth::user()->role }}. Anda memiliki <span class="font-bold">{{ $menungguVerifikasi }}</span> dokumen yang menunggu proses verifikasi hari ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Total Arsip</p>
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mt-4">{{ number_format($totalArsip) }}</h3>
            <p class="text-xs text-gray-400 font-medium mt-2 flex items-center">
                Total arsip permanen
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Menunggu Verifikasi</p>
                <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mt-4">{{ number_format($menungguVerifikasi) }}</h3>
            <p class="text-xs text-yellow-600 font-medium mt-2 flex items-center">
                Harus segera diproses
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Dokumen Ditolak</p>
                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mt-4">{{ number_format($dokumenDitolak) }}</h3>
            <p class="text-xs text-gray-500 font-medium mt-2 flex items-center">
                Menunggu revisi karyawan
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Total Pengguna</p>
                <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mt-4">{{ number_format($totalPengguna) }}</h3>
            <p class="text-xs text-gray-500 font-medium mt-2 flex items-center">
                Admin, Pimpinan, & Karyawan
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div>
                <h3 class="font-bold text-gray-900">Antrean Verifikasi Dokumen</h3>
                <p class="text-xs text-gray-500 mt-1">Dokumen yang baru diunggah oleh staf karyawan</p>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm font-semibold text-primary hover:text-primary-hover transition">
                Lihat Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Tanggal Upload</th>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    
                    {{-- Looping data dokumen menggunakan @forelse untuk handle jika tabel kosong --}}
                    @forelse ($dokumenTerbaru as $dokumen)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($dokumen->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $dokumen->judul_dokumen }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">
                                    {{ $dokumen->keterangan ?? 'Tidak ada keterangan tambahan' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                    {{ $dokumen->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    {{-- Mengambil huruf pertama dari nama pengirim untuk avatar --}}
                                    <div class="w-7 h-7 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-xs font-bold mr-2">
                                        {{ strtoupper(substr($dokumen->pengirim->nama_user ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-700">
                                        {{ $dokumen->pengirim->nama_user ?? 'Sistem' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.verifikasi.index') }}" class="inline-block bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">
                                    Tinjau & Validasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                <p class="font-medium">Hore! Tidak ada dokumen yang menunggu verifikasi saat ini.</p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>