<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | TK Aqila')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 font-sans text-zinc-900 antialiased">
    <div class="min-h-screen flex">
        {{-- Sidebar Overlay (mobile) --}}
        <div id="adminSidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

        {{-- Sidebar --}}
        <aside id="adminSidebar" class="w-[260px] bg-zinc-950 text-zinc-400 flex flex-col fixed inset-y-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-200 border-r border-zinc-800">
            {{-- Brand --}}
            <div class="h-14 flex items-center px-5 border-b border-zinc-800">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/logo-tkaqila.png') }}" alt="Logo" class="w-7 h-7 rounded-md object-cover shrink-0">
                    <div class="leading-tight">
                        <p class="text-zinc-100 font-semibold text-sm tracking-tight">TK Aqila</p>
                        <p class="text-[10px] text-zinc-500">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <p class="px-3 mb-2 text-[10px] font-semibold text-zinc-600 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ url('/dashboard') }}" class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors @if(request()->is('dashboard')) bg-zinc-800 text-zinc-100 @else hover:bg-zinc-800/60 hover:text-zinc-200 @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ url('/admin/konten') }}" class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors @if(request()->is('admin/konten*')) bg-zinc-800 text-zinc-100 @else hover:bg-zinc-800/60 hover:text-zinc-200 @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Konten Website</span>
                </a>

                <a href="{{ url('/admin/pendaftar') }}" class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors @if(request()->is('admin/pendaftar*')) bg-zinc-800 text-zinc-100 @else hover:bg-zinc-800/60 hover:text-zinc-200 @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Data Pendaftar</span>
                </a>

                <a href="{{ url('/admin/jadwal') }}" class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors @if(request()->is('admin/jadwal*')) bg-zinc-800 text-zinc-100 @else hover:bg-zinc-800/60 hover:text-zinc-200 @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Jadwal Kelas</span>
                </a>

                <a href="{{ url('/admin/laporan') }}" class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors @if(request()->is('admin/laporan*')) bg-zinc-800 text-zinc-100 @else hover:bg-zinc-800/60 hover:text-zinc-200 @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Laporan</span>
                </a>
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-3 border-t border-zinc-800">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 rounded-md text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 md:ml-[260px]">
            {{-- Top Header --}}
            <header class="sticky top-0 z-20 bg-zinc-50/80 backdrop-blur-md border-b border-zinc-200">
                <div class="flex items-center justify-between h-14 px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button id="adminSidebarToggle" type="button" class="md:hidden inline-flex items-center justify-center h-8 w-8 rounded-md border border-zinc-200 bg-white text-zinc-600 shadow-sm hover:bg-zinc-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div>
                            <h1 class="text-sm font-semibold text-zinc-900">@yield('page_title', 'Dashboard')</h1>
                            <p class="text-xs text-zinc-500 hidden sm:block">@yield('page_subtitle', 'Ringkasan pendaftaran TK Aqila')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-xs font-medium text-zinc-700">{{ session('admin_name', 'Admin') }}</span>
                            <span class="text-[11px] text-zinc-400">{{ session('admin_email') }}</span>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-emerald-600 to-amber-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                            {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="p-4 sm:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminSidebarOverlay');
            var toggle = document.getElementById('adminSidebarToggle');

            function openSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }

            if (toggle) toggle.addEventListener('click', openSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) closeSidebar();
            });
        })();
    </script>
</body>
</html>
