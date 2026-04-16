@php
    $nav = [
        ['label' => 'Home', 'href' => url('/')],
        ['label' => 'Profil', 'href' => url('/#profil')],
        ['label' => 'Pendaftaran', 'href' => url('/pendaftaran')],
        ['label' => 'Jadwal', 'href' => url('/#jadwal')],
    ];
@endphp

<header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-linear-to-tr from-[#4F46E5] to-[#10B981] flex items-center justify-center text-white font-bold shadow-sm">
                    A
                </div>
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm sm:text-base tracking-tight">TK Aqila</span>
                    <span class="text-[11px] text-[#6B7280] hidden sm:block">Bermain • Belajar • Tumbuh</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm text-[#374151]">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}" class="hover:text-[#4F46E5] transition-colors">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ url('/login') }}" class="hidden sm:inline-flex px-3 py-2 rounded-full text-sm font-medium text-[#4F46E5] border border-[#4F46E5]/20 hover:bg-[#4F46E5]/5 transition-colors">
                    Login Admin
                </a>
                <a href="{{ url('/pendaftaran') }}" class="inline-flex px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#4F46E5] hover:bg-[#4338CA] shadow-sm hover:shadow-md transition-all">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</header>
