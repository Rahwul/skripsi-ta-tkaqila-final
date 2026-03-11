<footer class="mt-16 bg-[#111827] text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid gap-10 md:grid-cols-3">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-2xl bg-linear-to-tr from-[#4F46E5] to-[#10B981] flex items-center justify-center text-white font-bold shadow-sm">
                    A
                </div>
                <div class="leading-tight">
                    <p class="text-white font-semibold">TK Aqila</p>
                    <p class="text-[11px] text-gray-400">PAUD / TK • Kabupaten Bogor</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed">
                Lembaga pendidikan anak usia dini yang berfokus pada pembelajaran menyenangkan, pembentukan karakter,
                dan pengembangan potensi anak.
            </p>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-3 text-sm">Kontak</h3>
            <ul class="space-y-2 text-xs text-gray-400">
                <li>Jl. Pendidikan No. 123, Kabupaten Bogor</li>
                <li>Telp/WA: +62 812-3456-7890</li>
                <li>Email: info@tkaqila.sch.id</li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-3 text-sm">Link Cepat</h3>
            <ul class="space-y-2 text-xs text-gray-400">
                <li><a class="hover:text-white" href="{{ url('/') }}">Beranda</a></li>
                <li><a class="hover:text-white" href="{{ url('/#profil') }}">Tentang Kami</a></li>
                <li><a class="hover:text-white" href="{{ url('/pendaftaran') }}">Pendaftaran</a></li>
                <li><a class="hover:text-white" href="{{ url('/#fasilitas') }}">Fasilitas</a></li>
                <li><a class="hover:text-white" href="{{ url('/#ekskul') }}">Ekstrakurikuler</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 py-3 text-center text-[11px] text-gray-500">
        © {{ date('Y') }} TK Aqila. Semua hak dilindungi.
    </div>
</footer>
