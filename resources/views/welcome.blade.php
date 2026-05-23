@extends('layouts.app')

@section('title', 'TK Aqila | Pendaftaran Online')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#f0fdf4] via-white to-[#fefce8]">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-emerald-100/60 blur-3xl"></div>
            <div class="absolute top-1/2 -right-16 w-64 h-64 rounded-full bg-amber-100/50 blur-3xl"></div>
        </div>
        <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8 py-20 lg:py-28 flex flex-col lg:flex-row items-center gap-12">
            <div class="w-full lg:w-1/2 space-y-5">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-xs font-medium text-emerald-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $content['landing.hero_badge'] ?? 'Pendaftaran Masih Dibuka!' }}
                </span>
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 leading-[1.15]">
                    {{ $content['landing.hero_title_line1'] ?? 'Pendaftaran Online' }}
                    <span class="block mt-1 bg-gradient-to-r from-emerald-600 to-amber-500 bg-clip-text text-transparent">
                        {{ $content['landing.hero_title_highlight'] ?? 'TK Aqila' }}
                    </span>
                </h1>
                <p class="text-base text-gray-500 leading-relaxed max-w-lg">
                    {{ $content['landing.hero_description'] ?? 'Daftarkan putra-putri Anda dengan mudah dan cepat melalui sistem pendaftaran online kami. Proses sederhana, transparan, dan dapat diakses kapan saja.' }}
                </p>
                <ul class="space-y-2.5 text-sm text-gray-600">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $content['landing.feature_1'] ?? 'Pembelajaran berbasis bermain yang menyenangkan dan aman.' }}
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $content['landing.feature_2'] ?? 'Orang tua dapat memantau status pendaftaran secara online.' }}
                    </li>
                </ul>
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ url('/pendaftaran') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow-lg shadow-emerald-600/25 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all">
                        Daftar Sekarang
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </a>
                    <a href="#profil" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-600 hover:bg-gray-50 shadow-sm transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-1/2 flex justify-center">
                <img src="{{ asset('images/hero-illustration.png') }}" alt="Ilustrasi TK Aqila" class="w-full max-w-md rounded-3xl drop-shadow-xl">
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="bg-white py-10">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center py-5 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-2xl font-bold text-emerald-600">{{ $content['landing.stats_alumni'] ?? '500+' }}</p>
                    <p class="text-xs text-gray-500 mt-1">Siswa Alumni</p>
                </div>
                <div class="text-center py-5 rounded-2xl bg-amber-50 border border-amber-100">
                    <p class="text-2xl font-bold text-amber-600">{{ $content['landing.stats_pengalaman'] ?? '15+' }}</p>
                    <p class="text-xs text-gray-500 mt-1">Tahun Pengalaman</p>
                </div>
                <div class="text-center py-5 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-2xl font-bold text-emerald-600">{{ $content['landing.stats_guru'] ?? '20+' }}</p>
                    <p class="text-xs text-gray-500 mt-1">Guru Profesional</p>
                </div>
                <div class="text-center py-5 rounded-2xl bg-amber-50 border border-amber-100">
                    <p class="text-2xl font-bold text-amber-600">{{ $content['landing.stats_kepuasan'] ?? '100%' }}</p>
                    <p class="text-xs text-gray-500 mt-1">Kepuasan Orang Tua</p>
                </div>
            </div>
        </div>
    </section>

    {{-- JADWAL --}}
    <section id="jadwal" class="bg-gray-50/50 py-20">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mb-2">Jadwal Kami</p>
            <h2 class="text-3xl font-extrabold text-gray-900">Jadwal Belajar yang Teratur</h2>
            <p class="mt-3 text-sm text-gray-500 max-w-lg mx-auto">Kami memastikan kegiatan belajar berjalan secara terstruktur, menyenangkan, dan bermakna.</p>
            <div class="mt-10 grid sm:grid-cols-3 gap-5">
                @php $jadwalCards = [
                    ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Hari Sekolah', 'desc' => 'Senin – Jumat', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                    ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jam Kegiatan', 'desc' => '08.00 – 11.00 WIB', 'bg' => 'bg-amber-50', 'tc' => 'text-amber-600'],
                    ['icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'title' => 'Kegiatan Utama', 'desc' => 'Motorik, literasi, seni & karakter', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                ]; @endphp
                @foreach ($jadwalCards as $jc)
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <div class="w-14 h-14 mx-auto rounded-2xl {{ $jc['bg'] }} {{ $jc['tc'] }} flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $jc['icon'] }}"/></svg>
                        </div>
                        <p class="font-semibold text-gray-900">{{ $jc['title'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $jc['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <a href="{{ url('/pendaftaran') }}" class="mt-8 inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow-md hover:bg-emerald-700 transition-all">
                Cek & Daftar Sekarang →
            </a>
        </div>
    </section>

    {{-- TENTANG KAMI --}}
    <section id="profil" class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-14">
                <div class="w-full lg:w-5/12">
                    <img src="{{ asset('images/about-illustration.png') }}" alt="Tentang TK Aqila" class="w-full max-w-sm mx-auto rounded-3xl drop-shadow-lg">
                </div>
                <div class="w-full lg:w-7/12 space-y-4">
                    <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest">Tentang Kami</p>
                    <h2 class="text-3xl font-extrabold text-gray-900 leading-snug">
                        {{ $content['landing.about_heading'] ?? 'Membangun Generasi' }}
                        <span class="text-emerald-600">{{ $content['landing.about_heading_highlight'] ?? 'Cerdas & Berkarakter' }}</span>
                    </h2>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        {{ $content['landing.about_description'] ?? 'TK Aqila adalah lembaga pendidikan anak usia dini yang berdedikasi untuk memberikan pendidikan berkualitas tinggi dalam lingkungan yang aman, menyenangkan, dan penuh kasih sayang.' }}
                    </p>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        @php $keunggulan = [
                            ['t' => 'Kurikulum Terbaik', 'd' => 'Merdeka Belajar terintegrasi', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 7l-9-5 9-5 9 5-9 5z'],
                            ['t' => 'Lingkungan Aman', 'd' => 'Fasilitas ramah anak', 'bg' => 'bg-amber-50', 'tc' => 'text-amber-600', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['t' => 'Terakreditasi', 'd' => 'Standar nasional terpenuhi', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                            ['t' => 'Penuh Kasih Sayang', 'd' => 'Guru yang peduli & sabar', 'bg' => 'bg-rose-50', 'tc' => 'text-rose-500', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                        ]; @endphp
                        @foreach ($keunggulan as $k)
                            <div class="flex items-start gap-3 p-3.5 rounded-xl {{ $k['bg'] }} border border-transparent">
                                <div class="w-9 h-9 rounded-lg {{ $k['bg'] }} {{ $k['tc'] }} flex items-center justify-center shrink-0">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $k['icon'] }}"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $k['t'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $k['d'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GURU --}}
    <section class="bg-gray-50/50 py-20">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mb-2">Tim Pengajar</p>
            <h2 class="text-3xl font-extrabold text-gray-900">Guru Profesional & Berdedikasi</h2>
            <p class="mt-3 text-sm text-gray-500 max-w-lg mx-auto">Tenaga pengajar berpengalaman dan bersertifikasi yang penuh kasih sayang.</p>
            <div class="mt-10 grid sm:grid-cols-3 gap-5">
                @php $gurus = [
                    ['n' => 'Cecilia Estiarini, S.Pd., M.M.', 'r' => 'Kepala Sekolah', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                    ['n' => 'Andela, S.Psi.', 'r' => 'Wakil Kepala', 'bg' => 'bg-amber-50', 'tc' => 'text-amber-600'],
                    ['n' => 'Anastasia Jayani', 'r' => 'Guru Kelompok Bermain', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                ]; @endphp
                @foreach ($gurus as $g)
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 text-center hover:shadow-md transition-all">
                        <div class="w-16 h-16 mx-auto rounded-full {{ $g['bg'] }} flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 {{ $g['tc'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <p class="font-semibold text-gray-900">{{ $g['n'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $g['r'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- LANGKAH PENDAFTARAN --}}
    <section class="bg-white py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mb-2">Cara Mendaftar</p>
            <h2 class="text-3xl font-extrabold text-gray-900">Langkah Pendaftaran Mudah</h2>
            <p class="mt-3 text-sm text-gray-500 max-w-lg mx-auto">Hanya 3 langkah sederhana untuk mendaftarkan putra-putri Anda di TK Aqila.</p>
            <div class="mt-10 grid sm:grid-cols-3 gap-8">
                @php $steps = [
                    ['n' => '1', 'title' => 'Isi Formulir Online', 'desc' => 'Kunjungi website, klik daftar, dan isi data lengkap calon siswa.'],
                    ['n' => '2', 'title' => 'Upload Berkas', 'desc' => 'Unggah dokumen yang dibutuhkan seperti akta dan kartu keluarga.'],
                    ['n' => '3', 'title' => 'Siap Diterima', 'desc' => 'Tim kami akan meninjau dan menghubungi Anda untuk konfirmasi.'],
                ]; @endphp
                @foreach ($steps as $st)
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto rounded-full bg-emerald-600 text-white flex items-center justify-center text-lg font-bold shadow-lg shadow-emerald-600/25 mb-3">{{ $st['n'] }}</div>
                        <p class="font-semibold text-gray-900">{{ $st['title'] }}</p>
                        <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">{{ $st['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <a href="{{ url('/pendaftaran') }}" class="mt-10 inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow-md hover:bg-emerald-700 transition-all">
                Mulai Pendaftaran Online →
            </a>
        </div>
    </section>

    @include('partials.landing-bottom')
@endsection
