<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | TK Aqila')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F3F8FF] font-sans text-gray-900">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <div id="adminSidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>
        <aside id="adminSidebar" class="w-64 bg-[#111827] text-white flex flex-col fixed inset-y-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-200">
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-2xl bg-linear-to-tr from-[#4F46E5] to-[#10B981] flex items-center justify-center text-white font-bold group-hover:scale-110 transition-transform">
                        A
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold text-sm">TK Aqila</p>
                        <p class="text-[11px] text-white/60">Admin Panel</p>
                    </div>
                </a>
            </div>
            <nav class="p-4 space-y-2 flex-1 overflow-y-auto text-sm">
                <div class="px-4 py-2 text-[10px] font-bold text-white/50 uppercase tracking-wider">Menu Utama</div>
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/10 @if(request()->is('dashboard')) bg-white/10 @endif">
                    <span class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center text-xs">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/admin/konten') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/10 @if(request()->is('admin/konten*')) bg-white/10 @endif">
                    <span class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center text-xs">📝</span>
                    <span>Konten Website</span>
                </a>
                <a href="{{ url('/admin/pendaftar') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/10 @if(request()->is('admin/pendaftar*')) bg-white/10 @endif">
                    <span class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center text-xs">👨‍👩‍👧</span>
                    <span>Data Pendaftar</span>
                </a>
                <a href="{{ url('/admin/jadwal') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/10 @if(request()->is('admin/jadwal*')) bg-white/10 @endif">
                    <span class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center text-xs">📅</span>
                    <span>Jadwal Kelas</span>
                </a>
                <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/10 @if(request()->is('admin/laporan*')) bg-white/10 @endif">
                    <span class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center text-xs">📊</span>
                    <span>Laporan</span>
                </a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-red-300 hover:bg-red-500/10 rounded-xl text-sm font-medium transition-colors">
                        <span class="w-5 h-5 rounded-lg bg-red-500/20 flex items-center justify-center text-xs">⎋</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 sm:p-6 lg:p-8">
            <header class="flex items-center justify-between mb-6">
                <div>
                    <button id="adminSidebarToggle" type="button" class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-[#111827] shadow-sm mr-2">
                        <span class="text-lg leading-none">≡</span>
                    </button>
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-[#111827]">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs sm:text-sm text-[#6B7280] mt-1">@yield('page_subtitle', 'Ringkasan pendaftaran TK Aqila')</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col items-end text-xs text-[#6B7280]">
                        <span class="font-semibold text-[#111827]">{{ session('admin_name', 'Admin') }}</span>
                        <span>{{ session('admin_email') }}</span>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-linear-to-tr from-[#4F46E5] to-[#10B981] flex items-center justify-center text-white text-sm font-bold shadow-md">
                        {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                    </div>
                </div>
            </header>

            @yield('content')
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
