@extends('layouts.app')

@section('title', 'Form Pendaftaran Online | TK Aqila')

@section('content')
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[11px] font-semibold text-emerald-700">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Formulir Pendaftaran
                </span>
                <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                    Form Pendaftaran Peserta Didik Baru
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Silakan lengkapi data berikut dengan benar. Data akan dikirim ke sistem pendaftaran TK Aqila dan akan diverifikasi oleh admin.
                </p>
            </div>

            {{-- Statistik Pendaftaran --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold text-emerald-600">47</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Total Pendaftar</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold text-amber-500">12</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Menunggu Verifikasi</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold text-blue-500">8</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Sedang Diproses</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold text-emerald-600">27</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Diterima</p>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-lg border border-gray-100 p-6 sm:p-8">
                {{-- Stepper --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center gap-3">
                            <div id="stepDot1" class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">1</div>
                            <span class="font-semibold text-gray-900">Data Anak</span>
                        </div>
                        <div class="flex-1 mx-4 h-px bg-gray-200"></div>
                        <div class="flex items-center gap-3">
                            <div id="stepDot2" class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold">2</div>
                            <span id="stepLabel2">Data Orang Tua</span>
                        </div>
                        <div class="flex-1 mx-4 h-px bg-gray-200 hidden sm:block"></div>
                        <div class="hidden sm:flex items-center gap-3">
                            <div id="stepDot3" class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold">3</div>
                            <span id="stepLabel3">Review</span>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-400">
                        Isi data dengan benar. Setelah dikirim, admin akan memverifikasi pendaftaran Anda.
                    </p>
                </div>

                <form id="pendaftaranForm" method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6">
                    @csrf

                    {{-- Data Anak --}}
                    <div id="step1" class="space-y-4">
                        <h2 class="text-sm font-semibold text-gray-900">Data Anak</h2>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap Anak</label>
                                <input type="text" name="nama_anak" value="{{ old('nama_anak') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                            </div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required
                                        class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                                    <option value="">Pilih salah satu</option>
                                    <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Data Orang Tua --}}
                    <div id="step2" class="space-y-4 hidden">
                        <h2 class="text-sm font-semibold text-gray-900">Data Orang Tua / Wali</h2>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nama Orang Tua / Wali</label>
                                <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">No. HP Aktif</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" required
                                      class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div id="step3" class="space-y-4 hidden">
                        <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Catatan Tambahan (opsional)</label>
                        <textarea name="catatan" rows="2"
                                  class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm outline-none transition-colors">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4">
                            <p class="text-sm font-semibold text-gray-900 mb-2">Review singkat</p>
                            <p class="text-xs text-gray-500">Pastikan data sudah benar sebelum dikirim. Admin akan memverifikasi pendaftaran Anda dalam 1-3 hari kerja.</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <button id="btnPrev" type="button"
                                    class="hidden inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                                ← Kembali
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <button id="btnNext" type="button"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                                Lanjut →
                            </button>
                            <button id="btnSubmit" type="submit"
                                    class="hidden inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                                Kirim Pendaftaran
                            </button>
                        </div>
                        <a href="{{ url('/') }}" class="text-xs sm:text-sm text-gray-400 hover:text-emerald-600 transition-colors">
                            ← Kembali ke beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        (() => {
            const stepEls = [
                document.getElementById('step1'),
                document.getElementById('step2'),
                document.getElementById('step3'),
            ];

            const dots = [
                document.getElementById('stepDot1'),
                document.getElementById('stepDot2'),
                document.getElementById('stepDot3'),
            ];

            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');
            const btnSubmit = document.getElementById('btnSubmit');

            let step = 1;

            function setDot(i, active) {
                if (!dots[i]) return;
                dots[i].className = active
                    ? 'w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold'
                    : 'w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold';
            }

            function render() {
                stepEls.forEach((el, idx) => {
                    if (!el) return;
                    el.classList.toggle('hidden', (idx + 1) !== step);
                });

                setDot(0, step >= 1);
                setDot(1, step >= 2);
                setDot(2, step >= 3);

                btnPrev.classList.toggle('hidden', step === 1);
                btnNext.classList.toggle('hidden', step === 3);
                btnSubmit.classList.toggle('hidden', step !== 3);
            }

            btnPrev.addEventListener('click', () => {
                step = Math.max(1, step - 1);
                render();
            });

            btnNext.addEventListener('click', () => {
                step = Math.min(3, step + 1);
                render();
            });

            render();
        })();
    </script>
@endsection
