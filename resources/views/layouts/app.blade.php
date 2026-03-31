<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arsip PTPN IV') }}</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#4f46e5',
                        'primary-light': '#e0e7ff',
                        'primary-hover': '#4338ca',
                    }
                }
            }
        }
    </script>
    <style>
       
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; } /* Warna scrollbar konten light */
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Custom Scrollbar untuk Sidebar Gelap */
        .custom-scrollbar-dark::-webkit-scrollbar-thumb { background: #1e293b; } /* slate-800 */
        .custom-scrollbar-dark::-webkit-scrollbar-thumb:hover { background: #334155; } /* slate-700 */
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 font-sans antialiased overflow-hidden flex h-screen">

    @include('layouts.sidebar')

    <div id="mainContent" class="flex-1 flex flex-col h-screen overflow-hidden transition-all duration-300 ease-in-out md:ml-64 w-full relative z-10">
        
        <header class="h-16 bg-white/90 backdrop-blur-sm border-b border-gray-200 flex items-center justify-between px-4 sm:px-8 shrink-0 sticky top-0 shadow-sm z-20">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="mr-4 p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-primary transition focus:outline-none focus:ring-2 focus:ring-primary-light">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </button>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 tracking-tight truncate hidden sm:block">Dashboard {{ Auth::user()->role }}</h2>
            </div>
            
            <div onclick="openProfileModal()" class="flex items-center gap-3 cursor-pointer p-1.5 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-200 group">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-primary transition">{{ Auth::user()->nama_user }}</p>
                    <p class="text-xs text-gray-500 font-medium uppercase">{{ Auth::user()->role }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-blue-500 flex items-center justify-center text-white font-bold shadow-md shadow-primary/40 uppercase transform group-hover:scale-105 transition">
                    {{ substr(Auth::user()->nama_user, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 md:p-8 overflow-y-auto" id="mainScrollArea">
            {{ $slot }}
        </main>
        
    </div>

   @include('layouts.profil')
    <script>
        // --- Logika Toggle Sidebar yang Anti-Gagal ---
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Deteksi ukuran layar, otomatis true jika di Desktop
        let isSidebarOpen = window.innerWidth >= 768; 

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen; // Balikkan status
            
            if (isSidebarOpen) {
                // Aksi: BUKA SIDEBAR
                // Menggunakan !important classes (!-translate-x-full) untuk memaksakan prioritas CSS
                sidebar.classList.remove('!-translate-x-full'); 
                sidebar.classList.remove('-translate-x-full'); // untuk mobile
                
                mainContent.classList.add('md:ml-64'); 
                mainContent.classList.remove('!ml-0'); // hapus paksaan full-width
                
                // Munculkan overlay gelap jika di mobile
                if (window.innerWidth < 768) {
                    sidebarOverlay.classList.remove('hidden');
                    setTimeout(() => sidebarOverlay.classList.remove('opacity-0'), 10);
                }
            } else {
                // Aksi: TUTUP SIDEBAR
                // Paksa sidebar sembunyi walaupun sedang di Desktop (override md:translate-x-0)
                sidebar.classList.add('!-translate-x-full'); 
                
                // Paksa konten melebar penuh
                mainContent.classList.remove('md:ml-64'); 
                mainContent.classList.add('!ml-0'); 
                
                // Hilangkan overlay gelap
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
            }
        }

        // --- Logika Modal Profil (Animasi Scale & Fade) ---
        const profileModal = document.getElementById('profileModal');
        const profileModalContent = document.getElementById('profileModalContent');

        function openProfileModal() {
            profileModal.classList.remove('hidden');
            // Paksa reflow UI sebelum transisi agar animasinya berjalan halus
            void profileModal.offsetWidth; 
            
            profileModal.classList.remove('opacity-0');
            profileModalContent.classList.remove('scale-95');
            profileModalContent.classList.add('scale-100');
        }

        function closeProfileModal() {
            profileModal.classList.add('opacity-0');
            profileModalContent.classList.remove('scale-100');
            profileModalContent.classList.add('scale-95');
            
            setTimeout(() => {
                profileModal.classList.add('hidden');
            }, 300); // Waktu 300ms sesuai dengan duration-300 di class Tailwind
        }
    </script>

</body>
</html>