<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengarsipan Dokumen - PTPN IV</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'sans-serif'] },
                        colors: {
                            primary: '#4f46e5', // Indigo-600
                            'primary-hover': '#4338ca', // Indigo-700
                            'primary-light': '#e0e7ff' // Indigo-100
                        },
                        animation: {
                            'blob': 'blob 7s infinite',
                            'float': 'float 6s ease-in-out infinite',
                        },
                        keyframes: {
                            blob: {
                                '0%': { transform: 'translate(0px, 0px) scale(1)' },
                                '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                                '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                                '100%': { transform: 'translate(0px, 0px) scale(1)' },
                            },
                            float: {
                                '0%, 100%': { transform: 'translateY(0)' },
                                '50%': { transform: 'translateY(-20px)' },
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        /* Efek glassmorphism ekstra */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-[#f4f7fc] selection:bg-primary selection:text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 top-0 transition-all duration-500 glass-nav border-b border-gray-200/50 shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center gap-3 group cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="bg-gradient-to-tr from-primary to-blue-500 p-2 rounded-xl shadow-lg shadow-primary/30 w-12 h-12 flex items-center justify-center overflow-hidden transform transition-transform group-hover:rotate-6 group-hover:scale-105 duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-md">
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-gray-900 tracking-tight leading-tight">Arsip Pusat</h1>
                        <p class="text-[10px] text-primary font-bold uppercase tracking-widest leading-none">PTPN IV Reg III</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#tentang" class="text-sm font-semibold text-gray-500 hover:text-primary relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">Keunggulan</a>
                    <a href="#panduan" class="text-sm font-semibold text-gray-500 hover:text-primary relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">Alur Kerja</a>

                    @if (Route::has('login'))
                        <div class="flex items-center ml-4 pl-6 border-l border-gray-200">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-full shadow-lg shadow-primary/30 transition-all duration-300 overflow-hidden">
                                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                                    <span class="relative">Dashboard Saya</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-black rounded-full shadow-lg shadow-gray-900/30 transition-all duration-300 overflow-hidden hover:-translate-y-0.5">
                                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                                    <span class="relative flex items-center">
                                        Login Portal
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>

                <div class="md:hidden flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-primary font-bold text-sm mr-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-primary font-bold text-sm mr-4">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden min-h-screen flex items-center">
        <div class="absolute inset-0 w-full h-full bg-[#f4f7fc] z-0"></div>
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob z-0"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000 z-0"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-4000 z-0"></div>

        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBoNDBWMEgwem0zOSAzaC0zOXYtMzlNMzlWMGgtMzkiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgwLDAsMCwwLjA0KSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-50 z-0"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up" data-aos-duration="1000">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-sm border border-gray-200/50 text-gray-700 mb-8 shadow-sm" data-aos="fade-down" data-aos-delay="200">
                <span class="flex h-2.5 w-2.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span class="text-xs font-bold uppercase tracking-wider">Sistem Aktif & Terlindungi</span>
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 tracking-tight leading-[1.1] mb-6">
                Transformasi Digital <br class="hidden sm:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-blue-500 to-indigo-600 inline-block animate-float">Arsip Perusahaan</span>
            </h1>

            <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-600 mb-10 leading-relaxed font-medium" data-aos="fade-up" data-aos-delay="400">
                Pusat kendali dokumen elektronik PTPN IV Regional III. Ciptakan tata kelola administrasi yang <span class="text-primary font-bold">Aman</span>, <span class="text-primary font-bold">Cepat</span>, dan <span class="text-primary font-bold">Terstruktur</span>.
            </p>

            @if (Route::has('login'))
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4" data-aos="zoom-in" data-aos-delay="600">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-primary to-blue-600 hover:from-primary-hover hover:to-blue-700 rounded-full shadow-xl shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                        Buka Dashboard
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-4 text-base font-bold text-white bg-gray-900 hover:bg-black rounded-full shadow-xl shadow-gray-900/20 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center group">
                        Masuk Sistem
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endauth
            </div>
            @endif
        </div>
    </section>

    <section id="tentang" class="py-24 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20" data-aos="fade-up">
                <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Mengapa Sistem Ini?</h2>
                <h3 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Efisiensi Tanpa Batas</h3>
                <div class="h-1 w-20 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="glass-card rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(79,70,229,0.1)] transition-all duration-500 transform hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Keamanan Enkripsi</h4>
                    <p class="text-sm text-gray-500 leading-relaxed font-medium">
                        Dokumen sensitif disimpan di server terpusat dengan sistem proteksi ketat, meminimalisir risiko kebocoran dan kerusakan fisik akibat bencana.
                    </p>
                </div>

                <div class="glass-card rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(79,70,229,0.1)] transition-all duration-500 transform hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Pencarian Kilat</h4>
                    <p class="text-sm text-gray-500 leading-relaxed font-medium">
                        Tinggalkan cara lama. Temukan arsip tahunan dalam hitungan detik menggunakan filter pintar berdasarkan judul, kategori, atau tanggal.
                    </p>
                </div>

                <div class="glass-card rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(79,70,229,0.1)] transition-all duration-500 transform hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Sistem Disposisi</h4>
                    <p class="text-sm text-gray-500 leading-relaxed font-medium">
                        Alur komunikasi antar pimpinan, admin, dan staf direkam jelas melalui kotak masuk (Inbox) yang memuat instruksi dokumen.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="panduan" class="py-24 bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full mix-blend-screen filter blur-[100px] opacity-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20" data-aos="fade-up">
                <h2 class="text-primary-light font-bold tracking-widest uppercase text-sm mb-2">Panduan Cepat</h2>
                <h3 class="text-3xl md:text-4xl font-black mb-4">Siklus Dokumen Digital</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-6 relative">
                <div class="hidden md:block absolute top-10 left-12 w-[calc(100%-6rem)] h-[2px] bg-gradient-to-r from-gray-700 via-primary to-gray-700 z-0"></div>

                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-20 h-20 rounded-2xl bg-gray-800 border border-gray-700 flex items-center justify-center text-2xl font-black text-gray-400 mb-6 shadow-xl group-hover:bg-primary group-hover:text-white group-hover:border-primary group-hover:-translate-y-2 transition-all duration-300">
                        1
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-white">Unggah</h4>
                    <p class="text-sm text-gray-400 font-medium leading-relaxed px-2">Karyawan mengunggah softcopy beserta keterangan melalui portal.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-20 h-20 rounded-2xl bg-gray-800 border border-gray-700 flex items-center justify-center text-2xl font-black text-gray-400 mb-6 shadow-xl group-hover:bg-primary group-hover:text-white group-hover:border-primary group-hover:-translate-y-2 transition-all duration-300">
                        2
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-white">Verifikasi</h4>
                    <p class="text-sm text-gray-400 font-medium leading-relaxed px-2">Admin memeriksa keabsahan dan menolak atau menyetujui dokumen.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="zoom-in" data-aos-delay="500">
                    <div class="w-20 h-20 rounded-2xl bg-gray-800 border border-gray-700 flex items-center justify-center text-2xl font-black text-gray-400 mb-6 shadow-xl group-hover:bg-primary group-hover:text-white group-hover:border-primary group-hover:-translate-y-2 transition-all duration-300">
                        3
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-white">Arsip Permanen</h4>
                    <p class="text-sm text-gray-400 font-medium leading-relaxed px-2">Dokumen sah disimpan di database lengkap dengan letak fisik hardcopy.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="zoom-in" data-aos-delay="700">
                    <div class="w-20 h-20 rounded-2xl bg-gray-800 border border-gray-700 flex items-center justify-center text-2xl font-black text-gray-400 mb-6 shadow-xl group-hover:bg-primary group-hover:text-white group-hover:border-primary group-hover:-translate-y-2 transition-all duration-300">
                        4
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-white">Distribusi</h4>
                    <p class="text-sm text-gray-400 font-medium leading-relaxed px-2">Pimpinan merekap laporan, Admin mendisposisikan surat ke pihak terkait.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="bg-gray-900 p-1.5 rounded-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-sm">Arsip PTPN IV Reg III</span>
            </div>
            <p class="text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} Hak Cipta Dilindungi. Sistem Internal Perusahaan.
            </p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi animasi scroll
        AOS.init({
            once: true, // animasi hanya diputar sekali saat di-scroll
            offset: 100, // jarak elemen dari bawah viewport sebelum animasi dimulai
        });

        // Script untuk memberi efek shadow pada navbar saat di-scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>