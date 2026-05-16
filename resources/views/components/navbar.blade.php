<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-gray-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <img src="{{ asset('images/logo-tkaqila.png') }}" alt="Logo TK Aqila" class="w-9 h-9 rounded-lg object-cover">
            <div class="leading-tight">
                <span class="text-gray-900 font-bold text-sm">TK Aqila</span>
                <span class="hidden sm:block text-[10px] text-gray-400">Bermain · Belajar · Tumbuh</span>
            </div>
        </a>
        <div class="hidden md:flex items-center gap-7 text-sm text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-gray-900 font-medium text-gray-900 transition-colors">Home</a>
            <a href="#profil" class="hover:text-gray-900 transition-colors">Profil</a>
            <a href="{{ url('/pendaftaran') }}" class="hover:text-gray-900 transition-colors">Pendaftaran</a>
            <a href="#jadwal" class="hover:text-gray-900 transition-colors">Jadwal</a>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ url('/pendaftaran') }}" class="text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl shadow-sm transition-all">Daftar Sekarang</a>
        </div>
    </div>
</nav>
