@extends('layouts.app')

@section('title', 'TK Aqila | Pendaftaran Online')

@section('content')
    {{-- HERO UTAMA --}}
    <section class="relative overflow-hidden bg-linear-to-br from-[#F9FAFF] via-white to-[#E0F2FE]">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-[#4F46E5]/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-10 w-80 h-80 rounded-full bg-[#10B981]/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20 flex flex-col lg:flex-row items-center gap-10">
            <div class="w-full lg:w-1/2">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#ECFEFF] text-[11px] font-semibold text-[#0EA5E9] mb-4 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                    {{ $content['landing.hero_badge'] ?? 'Pendaftaran Masih Dibuka!' }}
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#020617] leading-tight">
                    {{ $content['landing.hero_title_line1'] ?? 'Pendaftaran Online' }}
                    <span class="block bg-linear-to-r from-[#4F46E5] via-[#6366F1] to-[#22C55E] bg-clip-text text-transparent">
                        {{ $content['landing.hero_title_highlight'] ?? 'TK Aqila' }}
                    </span>
                </h1>
                <p class="mt-4 text-sm sm:text-base text-[#6B7280] leading-relaxed max-w-xl">
                    {{ $content['landing.hero_description'] ?? 'Daftarkan putra-putri Anda dengan mudah dan cepat melalui sistem pendaftaran online kami. Proses sederhana, transparan, dan dapat diakses kapan saja oleh orang tua.' }}
                </p>
                <ul class="mt-4 space-y-2 text-xs sm:text-sm text-[#4B5563]">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 w-4 h-4 rounded-full bg-[#22C55E]/10 text-[#22C55E] flex items-center justify-center text-[10px]">✓</span>
                        <span>{{ $content['landing.feature_1'] ?? 'Pembelajaran berbasis bermain yang menyenangkan dan aman.' }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 w-4 h-4 rounded-full bg-[#22C55E]/10 text-[#22C55E] flex items-center justify-center text-[10px]">✓</span>
                        <span>{{ $content['landing.feature_2'] ?? 'Orang tua dapat memantau status pendaftaran secara online.' }}</span>
                    </li>
                </ul>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ url('/pendaftaran') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-linear-to-r from-[#4F46E5] to-[#6366F1] text-white text-sm font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        Daftar Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#profil"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 bg-white text-xs sm:text-sm text-[#374151] hover:bg-gray-50 shadow-sm transition-all">
                        Pelajari Lebih
                    </a>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="relative mx-auto max-w-md">
                    <div class="absolute -inset-4 rounded-4xl bg-linear-to-tr from-[#4F46E5]/40 via-[#22C55E]/30 to-[#F59E0B]/40 blur-2xl opacity-90"></div>
                    <div class="relative rounded-4xl bg-white/80 backdrop-blur-2xl shadow-[0_24px_60px_rgba(15,23,42,0.18)] border border-white/60 overflow-hidden">
                        <div class="absolute top-4 right-4 w-12 h-12 rounded-2xl bg-[#F59E0B] text-white flex items-center justify-center shadow-lg">
                            🎨
                        </div>
                        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-2xl bg-[#10B981] text-white flex items-center justify-center shadow-lg">
                            🧩
                        </div>
                        <div class="w-full h-64 bg-linear-to-br from-[#EEF2FF] via-[#DBEAFE] to-[#F5F3FF] flex items-center justify-center">
                            <div class="relative w-56 h-40 rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.16)] border border-[#E5E7EB] overflow-hidden">
                                <div class="absolute -top-6 -left-6 w-16 h-16 rounded-3xl bg-[#4F46E5] opacity-80"></div>
                                <div class="absolute -bottom-10 -right-10 w-24 h-24 rounded-full bg-[#22C55E]/80"></div>
                                <div class="relative flex flex-col items-center justify-center h-full px-4">
                                    <div class="w-16 h-16 rounded-3xl bg-[#4F46E5] flex items-center justify-center mb-3">
                                        <span class="text-white text-xl font-bold">A</span>
                                    </div>
                                    <p class="text-xs font-semibold text-[#111827]">TK Aqila</p>
                                    <p class="text-[11px] text-[#6B7280] mt-1 text-center">
                                        Sekolah ramah anak dengan lingkungan belajar yang menyenangkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 flex items-center justify-between text-[11px] text-[#6B7280]">
                            <span class="inline-flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#22C55E]"></span>
                                Pendaftaran diproses oleh admin sekolah
                            </span>
                            <span class="font-semibold text-[#4F46E5]">Online 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STRIP STATISTIK --}}
    <section class="relative -mt-6 pb-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(15,23,42,0.16)] border border-white/70 grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100 overflow-hidden">
                <div class="px-5 py-4 sm:py-5 flex flex-col items-start sm:items-center gap-1">
                    <p class="text-xl sm:text-2xl font-extrabold text-[#4F46E5]">{{ $content['landing.stats_alumni'] ?? '500+' }}</p>
                    <p class="text-[11px] sm:text-xs text-[#6B7280]">Alumni Sukses</p>
                </div>
                <div class="px-5 py-4 sm:py-5 flex flex-col items-start sm:items-center gap-1">
                    <p class="text-xl sm:text-2xl font-extrabold text-[#22C55E]">{{ $content['landing.stats_pengalaman'] ?? '15+' }}</p>
                    <p class="text-[11px] sm:text-xs text-[#6B7280]">Tahun Pengalaman</p>
                </div>
                <div class="px-5 py-4 sm:py-5 flex flex-col items-start sm:items-center gap-1">
                    <p class="text-xl sm:text-2xl font-extrabold text-[#F59E0B]">{{ $content['landing.stats_guru'] ?? '20+' }}</p>
                    <p class="text-[11px] sm:text-xs text-[#6B7280]">Guru Profesional</p>
                </div>
                <div class="px-5 py-4 sm:py-5 flex flex-col items-start sm:items-center gap-1">
                    <p class="text-xl sm:text-2xl font-extrabold text-[#EC4899]">{{ $content['landing.stats_kepuasan'] ?? '100%' }}</p>
                    <p class="text-[11px] sm:text-xs text-[#6B7280]">Kepuasan Orang Tua</p>
                </div>
            </div>
        </div>
    </section>

    {{-- JADWAL --}}
    <section id="jadwal" class="py-16 bg-linear-to-b from-[#F9FAFF] to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E0F2FE] text-[11px] font-semibold text-[#0284C7]">
                    Jadwal Kelas
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-[#020617]">
                    Jadwal <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">Belajar yang Teratur</span>
                </h2>
                <p class="mt-2 text-sm text-[#6B7280]">
                    Struktur kegiatan harian yang seimbang antara bermain, belajar, dan istirahat.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#EEF2FF]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center font-bold mb-3">📅</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Hari Sekolah</p>
                        <p class="text-xs text-[#6B7280]">Senin–Jumat</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#ECFDF5]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center font-bold mb-3">⏰</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Jam Kegiatan</p>
                        <p class="text-xs text-[#6B7280]">08.00–11.00 WIB</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#FEF3C7]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#FEF3C7] text-[#F59E0B] flex items-center justify-center font-bold mb-3">🧠</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Kegiatan Utama</p>
                        <p class="text-xs text-[#6B7280]">Motorik, literasi, seni, dan karakter</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/pendaftaran') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#4F46E5] hover:bg-[#4338CA] text-white text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    Cek & Daftar Sekarang
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- TENTANG KAMI + KARTU KEUNGGULAN (2x2) --}}
    <section id="profil" class="py-16 bg-linear-to-b from-white via-[#F9FAFF] to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-2 items-center">
            <div class="order-2 lg:order-1 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-4 flex flex-col justify-between min-h-30">
                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-2xl bg-white text-[#4F46E5] shadow-sm mb-3">
                        <span class="text-lg">🎓</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#111827]">Kurikulum Terbaik</p>
                        <p class="mt-1 text-[11px] text-[#6B7280]">Mengembangkan potensi anak secara holistik.</p>
                    </div>
                </div>
                <div class="rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-4 flex flex-col justify-between min-h-30">
                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-2xl bg-white text-[#F59E0B] shadow-sm mb-3">
                        <span class="text-lg">🌞</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#111827]">Lingkungan Aman</p>
                        <p class="mt-1 text-[11px] text-[#6B7280]">Keamanan 24 jam dan area bermain yang terpantau.</p>
                    </div>
                </div>
                <div class="rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-4 flex flex-col justify-between min-h-30">
                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-2xl bg-white text-[#10B981] shadow-sm mb-3">
                        <span class="text-lg">🏅</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#111827]">Terakreditasi</p>
                        <p class="mt-1 text-[11px] text-[#6B7280]">Standar pendidikan sesuai ketentuan nasional.</p>
                    </div>
                </div>
                <div class="rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-4 flex flex-col justify-between min-h-30">
                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-2xl bg-white text-[#EC4899] shadow-sm mb-3">
                        <span class="text-lg">💖</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#111827]">Penuh Kasih Sayang</p>
                        <p class="mt-1 text-[11px] text-[#6B7280]">Guru yang peduli, sabar, dan dekat dengan anak.</p>
                    </div>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#ECFEFF] text-[11px] font-semibold text-[#0EA5E9]">
                    Tentang Kami
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-[#020617]">
                    {{ $content['landing.about_heading'] ?? 'Membangun Generasi' }}
                    <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">{{ $content['landing.about_heading_highlight'] ?? 'Cerdas & Berkarakter' }}</span>
                </h2>
                <p class="mt-3 text-sm sm:text-base text-[#6B7280] leading-relaxed">
                    {{ $content['landing.about_description'] ?? 'TK Aqila adalah lembaga pendidikan anak usia dini yang berdedikasi untuk memberikan pendidikan berkualitas tinggi dalam lingkungan yang aman, menyenangkan, dan penuh kasih sayang.' }}
                </p>
                <ul class="mt-4 space-y-2 text-xs sm:text-sm text-[#4B5563]">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 w-4 h-4 rounded-full bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center text-[10px]">✓</span>
                        <span>Pembelajaran berbasis bermain yang menyenangkan bagi anak.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 w-4 h-4 rounded-full bg-[#ECFDF5] text-[#10B981] flex items-center justify-center text-[10px]">✓</span>
                        <span>Pengembangan karakter dan moral yang kuat sejak dini.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 w-4 h-4 rounded-full bg-[#FEF3C7] text-[#F59E0B] flex items-center justify-center text-[10px]">✓</span>
                        <span>Fasilitas modern dan lingkungan yang nyaman bagi anak.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- GURU PROFESIONAL --}}
    <section id="guru" class="py-16 bg-[#F9FAFF]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#EEF2FF] text-[11px] font-semibold text-[#4F46E5]">
                    Tim Pengajar
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-[#020617]">
                    Guru <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">Profesional & Berdedikasi</span>
                </h2>
                <p class="mt-2 text-sm text-[#6B7280]">
                    Didampingi oleh guru-guru berpengalaman yang penuh kasih sayang untuk mendampingi tumbuh kembang anak.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl bg-white shadow-[0_20px_50px_rgba(15,23,42,0.14)] border border-white/70 px-5 py-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-[#EEF2FF] flex items-center justify-center mb-3">
                        <span class="text-2xl text-[#4F46E5]">👩‍🏫</span>
                    </div>
                    <p class="text-sm font-semibold text-[#111827]">Cecilia Estiarini, S.Pd., M.M.</p>
                    <p class="text-xs text-[#6B7280] mt-1">Kepala Sekolah</p>
                    <p class="text-[11px] text-[#6B7280] mt-2">Pengalaman lebih dari 15 tahun di bidang PAUD.</p>
                </div>
                <div class="rounded-3xl bg-white shadow-[0_20px_50px_rgba(15,23,42,0.14)] border border-white/70 px-5 py-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-[#ECFDF5] flex items-center justify-center mb-3">
                        <span class="text-2xl text-[#10B981]">👨‍🏫</span>
                    </div>
                    <p class="text-sm font-semibold text-[#111827]">Andela, S.Psi.</p>
                    <p class="text-xs text-[#6B7280] mt-1">Wakil Kepala</p>
                    <p class="text-[11px] text-[#6B7280] mt-2">Fokus pada pengembangan karakter dan emosi anak.</p>
                </div>
                <div class="rounded-3xl bg-white shadow-[0_20px_50px_rgba(15,23,42,0.14)] border border-white/70 px-5 py-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-[#FEF3C7] flex items-center justify-center mb-3">
                        <span class="text-2xl text-[#F59E0B]">📚</span>
                    </div>
                    <p class="text-sm font-semibold text-[#111827]">Anastasia Jayani</p>
                    <p class="text-xs text-[#6B7280] mt-1">Guru Kelompok Bermain</p>
                    <p class="text-[11px] text-[#6B7280] mt-2">Ahli dalam stimulasi kreativitas dan motorik halus.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- LANGKAH PENDAFTARAN --}}
    <section id="alur" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#ECFDF5] text-[11px] font-semibold text-[#10B981]">
                    Cara Pendaftaran
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-[#020617]">
                    Langkah <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">Pendaftaran Mudah</span>
                </h2>
                <p class="mt-2 text-sm text-[#6B7280]">
                    Ikuti 3 langkah sederhana untuk mendaftarkan putra-putri Anda di TK Aqila.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="relative rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-5 flex flex-col">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] text-sm font-bold mb-3">
                        1
                    </div>
                    <h3 class="text-sm font-semibold text-[#111827] mb-1">Isi Formulir Online</h3>
                    <p class="text-xs text-[#6B7280]">
                        Orang tua mengisi data lengkap anak dan kontak melalui form pendaftaran online.
                    </p>
                </div>
                <div class="relative rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-5 flex flex-col">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-2xl bg-[#DBEAFE] text-[#2563EB] text-sm font-bold mb-3">
                        2
                    </div>
                    <h3 class="text-sm font-semibold text-[#111827] mb-1">Upload Berkas</h3>
                    <p class="text-xs text-[#6B7280]">
                        Unggah dokumen pendukung seperti akta kelahiran dan Kartu Keluarga sesuai instruksi.
                    </p>
                </div>
                <div class="relative rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 p-5 flex flex-col">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-2xl bg-[#ECFDF5] text-[#10B981] text-sm font-bold mb-3">
                        3
                    </div>
                    <h3 class="text-sm font-semibold text-[#111827] mb-1">Verifikasi Admin</h3>
                    <p class="text-xs text-[#6B7280]">
                        Admin sekolah memeriksa data dan menghubungi orang tua untuk konfirmasi & jadwal daftar ulang.
                    </p>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/pendaftaran') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#22C55E] hover:bg-[#16A34A] text-white text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    Mulai Pendaftaran Online
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- EKSTRAKURIKULER --}}
    <section id="ekskul" class="py-16 bg-[#F9FAFF]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#FDF2FF] text-[11px] font-semibold text-[#EC4899]">
                    Ekstrakurikuler
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-center text-[#020617] mb-2">
                Kegiatan <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">Seru & Kreatif</span>
            </h2>
            <p class="text-sm text-[#6B7280] text-center max-w-2xl mx-auto mb-10">
                Berbagai kegiatan ekstrakurikuler untuk mengembangkan bakat dan minat anak.
            </p>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#FDF2FF]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#FDF2FF] text-[#EC4899] flex items-center justify-center font-bold mb-3">🎨</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Seni & Musik</p>
                    <p class="text-xs text-[#6B7280] mb-3">
                        Menggambar, mewarnai, menyanyi, dan bermain alat musik untuk mengekspresikan kreativitas.
                    </p>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-full bg-[#FDF2FF] text-[11px] text-[#EC4899]">Menggambar</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#EEF2FF] text-[11px] text-[#4F46E5]">Musik</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#DBEAFE] text-[11px] text-[#2563EB]">Menari</span>
                    </div>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#ECFDF5]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center font-bold mb-3">⚽</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Olahraga</p>
                    <p class="text-xs text-[#6B7280] mb-3">
                        Aktivitas fisik yang menyenangkan untuk menjaga kesehatan dan kebugaran tubuh anak.
                    </p>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-full bg-[#ECFDF5] text-[11px] text-[#10B981]">Senam</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#D1FAE5] text-[11px] text-[#059669]">Renang</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#FEF3C7] text-[11px] text-[#D97706]">Mini Soccer</span>
                    </div>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-[#EEF2FF]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center font-bold mb-3">🔬</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Kegiatan Sains</p>
                    <p class="text-xs text-[#6B7280] mb-3">
                        Eksperimen sederhana dan eksplorasi alam untuk menumbuhkan rasa ingin tahu anak.
                    </p>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-full bg-[#EEF2FF] text-[11px] text-[#4F46E5]">Eksperimen</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#E0F2FE] text-[11px] text-[#0284C7]">Berkebun</span>
                        <span class="px-2.5 py-1 rounded-full bg-[#F3E8FF] text-[11px] text-[#7C3AED]">Coding Kids</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FASILITAS --}}
    <section id="fasilitas" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#EEF2FF] text-[11px] font-semibold text-[#4F46E5]">
                    Fasilitas Kami
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-[#020617]">
                    Fasilitas <span class="bg-linear-to-r from-[#4F46E5] to-[#22C55E] bg-clip-text text-transparent">Lengkap & Modern</span>
                </h2>
                <p class="mt-2 text-sm text-[#6B7280]">
                    Kami menyediakan fasilitas terbaik untuk mendukung proses belajar mengajar yang optimal.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-[#EEF2FF]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center font-bold mb-3">🏫</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Ruang Kelas Nyaman</p>
                    <p class="text-xs text-[#6B7280]">
                        Ruang kelas ber-AC dengan dekorasi menarik dan perabotan yang aman untuk anak-anak.
                    </p>
                    <p class="mt-3 text-[11px] text-[#4F46E5] font-semibold">Lihat Detail →</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-[#ECFDF5]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center font-bold mb-3">📚</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Perpustakaan Mini</p>
                    <p class="text-xs text-[#6B7280]">
                        Koleksi buku cerita dan edukasi yang lengkap untuk menumbuhkan minat baca anak.
                    </p>
                    <p class="mt-3 text-[11px] text-[#10B981] font-semibold">Lihat Detail →</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-[0_18px_40px_rgba(15,23,42,0.12)] border border-gray-100 px-5 py-6">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-[#FEF3C7]"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-[#FEF3C7] text-[#F59E0B] flex items-center justify-center font-bold mb-3">🛝</div>
                        <p class="text-sm font-semibold text-[#111827] mb-1">Area Bermain Edukatif</p>
                    <p class="text-xs text-[#6B7280]">
                        Playground indoor & outdoor dengan permainan edukatif yang aman dan menyenangkan.
                    </p>
                    <p class="mt-3 text-[11px] text-[#F59E0B] font-semibold">Lihat Detail →</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
