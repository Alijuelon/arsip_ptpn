<x-app-layout>
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Log Aktivitas Unduh/Lihat</h2>
        <p class="text-sm text-gray-500 mt-1">Pantau siapa saja yang telah membuka atau mengunduh dokumen di sistem.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Waktu Akses</th>
                    <th class="px-6 py-4">Nama Pengguna</th>
                    <th class="px-6 py-4">Judul Dokumen yang Diakses</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                            {{ $log->created_at->format('d M Y') }}
                            <span class="block text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->format('H:i:s') }} WIB</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900">{{ $log->user->nama_user ?? 'User Dihapus' }}</span>
                            <span class="block text-xs text-gray-500">{{ $log->user->role ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-primary">{{ $log->dokumen->judul_dokumen ?? 'Dokumen Dihapus' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">Belum ada aktivitas akses dokumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50">{{ $logs->links() }}</div>
    </div>
</x-app-layout>