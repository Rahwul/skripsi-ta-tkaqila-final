<footer class="bg-[#064E3B] text-white pt-14 pb-6">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-3">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <img src="{{ asset('images/logo-tkaqila.png') }}" alt="Logo TK Aqila" class="w-8 h-8 rounded-lg object-cover">
                    <div>
                        <p class="font-bold text-sm">Sekolah 'Aqila</p>
                        <p class="text-[10px] text-emerald-300">KB & TKIT • Kab. Bogor</p>
                    </div>
                </div>
                <p class="text-xs text-emerald-200/80 leading-relaxed">Lembaga pendidikan anak usia dini yang berfokus pada pembelajaran menyenangkan, pembentukan karakter, dan pengembangan potensi anak.</p>
                <a href="https://www.instagram.com/tkit.aqila/" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-xs text-emerald-300 hover:text-white transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    @tkit.aqila
                </a>
            </div>
            <div>
                <p class="font-semibold text-sm mb-3">Kontak</p>
                <div class="space-y-2 text-xs text-emerald-200/80">
                    <p>Perum IPB Alam Sinarsari, Jl. Alam Sinarsari RT 04 RW 04</p>
                    <p>Kec. Dramaga, Kabupaten Bogor</p>
                    <p>(Samping Masjid Besar An-Nuur)</p>
                </div>
            </div>
            <div>
                <p class="font-semibold text-sm mb-3">Link Cepat</p>
                <div class="space-y-1.5 text-xs text-emerald-200/80">
                    <a href="{{ url('/') }}" class="block hover:text-white transition-colors">Beranda</a>
                    <a href="{{ url('/#profil') }}" class="block hover:text-white transition-colors">Tentang Kami</a>
                    <a href="{{ url('/pendaftaran') }}" class="block hover:text-white transition-colors">Pendaftaran</a>
                    <a href="{{ url('/#fasilitas') }}" class="block hover:text-white transition-colors">Fasilitas</a>
                    <a href="{{ url('/#ekskul') }}" class="block hover:text-white transition-colors">Ekstrakurikuler</a>
                </div>
            </div>
        </div>
        <div class="mt-10 pt-5 border-t border-emerald-700/50 text-center">
            <p class="text-[11px] text-emerald-300/60">&copy; {{ date('Y') }} Sekolah 'Aqila. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>
