<div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden opacity-0 transition-opacity duration-300 md:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 flex flex-col justify-between shadow-2xl z-[70] transform transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full">
    <div class="flex flex-col h-full overflow-hidden">
        
        <div class="h-20 flex items-center justify-between px-5 border-b border-gray-100 shrink-0 bg-white">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center bg-gray-50 border border-gray-100 rounded-xl p-1 shadow-sm w-11 h-11 transition transform hover:rotate-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PTPN IV" class="h-8 w-auto object-contain">
                </div>
                <div>
                    <span class="font-extrabold text-gray-900 tracking-tight text-lg block">Arsip Dokumen</span>
                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest -mt-1 block">PTPN IV</span>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500 focus:outline-none transition transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="px-4 py-6 space-y-1.5 overflow-y-auto flex-1 custom-scrollbar">
            
            {{-- ======================================================== --}}
            {{-- MENU KHUSUS ADMIN                                        --}}
            {{-- ======================================================== --}}
            @if(Auth::user()->role === 'Admin')
                <p class="px-3 text-[11px] font-bold text-gray-400 mb-3 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Main Menu</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard Admin
                    @if(request()->routeIs('admin.dashboard'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>
                
                <a href="{{ route('admin.verifikasi.index') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.verifikasi.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.verifikasi.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Verifikasi
                    </div>
                    @if(request()->routeIs('admin.verifikasi.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('admin.arsip.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.arsip.index') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.arsip.index') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Arsip Utama
                    @if(request()->routeIs('admin.arsip.index'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('admin.arsip.create') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.arsip.create') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.arsip.create') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Arsip Pusat
                    @if(request()->routeIs('admin.arsip.create'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition mt-6 relative overflow-hidden {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Pengguna
                    @if(request()->routeIs('admin.users.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.laporan.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Sistem
                    @if(request()->routeIs('admin.laporan.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>
                <a href="{{ route('admin.log.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.log.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.log.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"></path></svg>
                    Log Aktivitas Unduh
                    @if(request()->routeIs('admin.log.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <p class="px-3 text-[11px] font-bold text-gray-400 mt-8 mb-3 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Master Data</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('admin.kategori.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.kategori.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.kategori.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori Dokumen
                    @if(request()->routeIs('admin.kategori.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>
                
                <a href="{{ route('admin.departemen.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('admin.departemen.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.departemen.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Departemen
                    @if(request()->routeIs('admin.departemen.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

           {{-- ======================================================== --}}
            {{-- MENU KHUSUS KARYAWAN (STAFF)                             --}}
            {{-- ======================================================== --}}
            @elseif(Auth::user()->role === 'Staff')
                <p class="px-3 text-[11px] font-bold text-gray-400 mb-3 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Personal</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('karyawan.dashboard') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.dashboard') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard Saya
                    @if(request()->routeIs('karyawan.dashboard'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('karyawan.dokumen.create') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.dokumen.create') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.dokumen.create') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Baru
                    @if(request()->routeIs('karyawan.dokumen.create'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('karyawan.dokumen.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.dokumen.index') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.dokumen.index') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Riwayat Arsip
                    @if(request()->routeIs('karyawan.dokumen.index'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <p class="px-3 text-[11px] font-bold text-gray-400 mt-6 mb-2 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Pusat & Informasi</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('karyawan.arsip.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.arsip.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.arsip.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Arsip Pusat
                    @if(request()->routeIs('karyawan.arsip.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('karyawan.inbox.index') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.inbox.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.inbox.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        Disposisi Pimpinan
                    </div>
                    @if(request()->routeIs('karyawan.inbox.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('karyawan.email.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('karyawan.email.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('karyawan.email.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Inbox Email (Google)
                    @if(request()->routeIs('karyawan.email.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

            {{-- ======================================================== --}}
            {{-- MENU KHUSUS PIMPINAN                                     --}}
            {{-- ======================================================== --}}
            @elseif(Auth::user()->role === 'Pimpinan')
                <p class="px-3 text-[11px] font-bold text-gray-400 mb-3 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Executive Panel</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('pimpinan.dashboard') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('pimpinan.dashboard') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('pimpinan.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Monitoring Arsip
                    @if(request()->routeIs('pimpinan.dashboard'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('pimpinan.arsip.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('pimpinan.arsip.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('pimpinan.arsip.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Kelola Arsip Pusat
                    @if(request()->routeIs('pimpinan.arsip.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <a href="{{ route('pimpinan.surat.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('pimpinan.surat.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('pimpinan.surat.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Disposisi
                    @if(request()->routeIs('pimpinan.surat.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>

                <p class="px-3 text-[11px] font-bold text-gray-400 mt-6 mb-2 uppercase tracking-widest relative flex items-center">
                    <span class="flex-1">Pelaporan</span>
                    <span class="w-1/4 h-px bg-gray-200 ml-2"></span>
                </p>

                <a href="{{ route('pimpinan.laporan.index') }}" class="group flex items-center px-3.5 py-2.5 rounded-xl text-sm transition relative overflow-hidden {{ request()->routeIs('pimpinan.laporan.*') ? 'bg-primary text-white font-bold shadow-md shadow-primary/30' : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('pimpinan.laporan.*') ? 'text-white' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekap Laporan
                    @if(request()->routeIs('pimpinan.laporan.*'))
                        <div class="absolute inset-y-0 left-0 w-1 bg-white/50 rounded-r-full"></div>
                    @endif
                </a>
            @endif

        </nav>
    </div>

    <div class="px-4 py-4 border-t border-gray-100 shrink-0 bg-white">
        <div onclick="openProfileModal()" class="group flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 cursor-pointer transition mb-3 border border-transparent hover:border-gray-200">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-green-600 flex items-center justify-center text-white font-bold shadow-md shadow-green-900/20 uppercase transition-transform group-hover:scale-105">
                {{ substr(Auth::user()->nama_user, 0, 1) }}
            </div>
            <div class="flex-1 truncate">
                <p class="text-sm font-bold text-gray-900 truncate group-hover:text-primary transition-colors">{{ Auth::user()->nama_user }}</p>
                <p class="text-xs text-gray-500 font-medium tracking-wide uppercase">{{ Auth::user()->role }}</p>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>

        <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl text-sm font-bold transition duration-300 group border border-red-100 hover:border-red-600 shadow-sm">
            <svg class="w-4 h-4 mr-2.5 transition transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Keluar Aplikasi
        </button>
    </div>
</aside>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari Sistem?',
            text: "Sesi Anda akan segera berakhir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                title: 'text-gray-800 font-bold',
                htmlContainer: 'text-gray-500',
                confirmButton: 'rounded-lg px-5 py-2 font-semibold shadow-md',
                cancelButton: 'rounded-lg px-5 py-2 font-semibold shadow-md'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>