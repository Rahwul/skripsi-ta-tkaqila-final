{{-- EKSTRAKURIKULER --}}
<section id="ekskul" class="bg-gray-50/50 py-20">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
        <p class="text-xs font-semibold text-amber-600 uppercase tracking-widest mb-2">Ekstrakurikuler</p>
        <h2 class="text-3xl font-extrabold text-gray-900">Kegiatan Seru & Kreatif</h2>
        <p class="mt-3 text-sm text-gray-500 max-w-lg mx-auto">Berbagai kegiatan untuk mengembangkan bakat dan minat anak secara optimal.</p>
        <div class="mt-10 grid sm:grid-cols-3 gap-5">
            @php $ekskuls = [
                ['t' => 'Seni & Musik', 'd' => 'Menggambar, mewarnai, menyanyi, dan bermain alat musik untuk kreativitas.', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3', 'bg' => 'bg-amber-50', 'tc' => 'text-amber-600'],
                ['t' => 'Olahraga', 'd' => 'Aktivitas fisik menyenangkan untuk kesehatan dan kebugaran tubuh anak.', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                ['t' => 'Kegiatan Sains', 'd' => 'Eksperimen sederhana dan eksplorasi alam untuk rasa ingin tahu anak.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'bg' => 'bg-indigo-50', 'tc' => 'text-indigo-600'],
            ]; @endphp
            @foreach ($ekskuls as $ek)
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 text-left hover:shadow-md hover:-translate-y-0.5 transition-all group">
                    <div class="w-14 h-14 rounded-2xl {{ $ek['bg'] }} {{ $ek['tc'] }} flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ek['icon'] }}"/></svg>
                    </div>
                    <p class="font-semibold text-gray-900 mb-1">{{ $ek['t'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $ek['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FASILITAS --}}
<section id="fasilitas" class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
        <p class="text-xs font-semibold text-amber-600 uppercase tracking-widest mb-2">Fasilitas Kami</p>
        <h2 class="text-3xl font-extrabold text-gray-900">Fasilitas Lengkap & Modern</h2>
        <p class="mt-3 text-sm text-gray-500 max-w-lg mx-auto">Kami menyediakan fasilitas terbaik untuk mendukung proses belajar mengajar yang optimal.</p>
        <div class="mt-10 grid sm:grid-cols-3 gap-5">
            @php $fasils = [
                ['t' => 'Ruang Kelas Nyaman', 'd' => 'Ruang kelas ber-AC dengan dekorasi menarik dan aman untuk anak-anak.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
                ['t' => 'Perpustakaan Mini', 'd' => 'Koleksi buku cerita dan edukasi untuk menumbuhkan minat baca anak.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'bg' => 'bg-amber-50', 'tc' => 'text-amber-600'],
                ['t' => 'Area Bermain Edukatif', 'd' => 'Playground indoor & outdoor dengan permainan edukatif yang menyenangkan.', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-emerald-50', 'tc' => 'text-emerald-600'],
            ]; @endphp
            @foreach ($fasils as $fl)
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 text-left hover:shadow-md hover:-translate-y-0.5 transition-all group">
                    <div class="w-14 h-14 rounded-2xl {{ $fl['bg'] }} {{ $fl['tc'] }} flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $fl['icon'] }}"/></svg>
                    </div>
                    <p class="font-semibold text-gray-900 mb-1">{{ $fl['t'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $fl['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
