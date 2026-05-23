<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | TK Aqila</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-bg {
            background: linear-gradient(135deg, #064E3B 0%, #065F46 40%, #047857 100%);
        }
        .login-card {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
        }
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
        }
        .float-animation {
            animation: floatUp 6s ease-in-out infinite;
        }
        .float-animation-delay {
            animation: floatUp 6s ease-in-out infinite;
            animation-delay: -3s;
        }
        @keyframes floatUp {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .pattern-dots {
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- Left Side: Green Brand Panel --}}
    <div class="hidden lg:flex lg:w-[55%] login-bg relative overflow-hidden pattern-dots">
        {{-- Decorative circles --}}
        <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -right-16 w-80 h-80 rounded-full bg-white/5"></div>
        <div class="absolute top-1/4 right-10 w-32 h-32 rounded-full bg-amber-400/10"></div>

        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-tkaqila.png') }}" alt="Logo TK Aqila" class="w-11 h-11 rounded-xl object-cover shadow-lg shadow-black/20">
                <div>
                    <p class="text-white font-bold text-lg tracking-tight">Sekolah 'Aqila</p>
                    <p class="text-emerald-200/70 text-xs">KB & TKIT • Kab. Bogor</p>
                </div>
            </div>

            {{-- Illustration --}}
            <div class="flex-1 flex items-center justify-center py-8">
                <div class="relative max-w-md w-full">
                    <div class="absolute inset-0 bg-white/5 rounded-3xl blur-2xl transform rotate-3"></div>
                    <img src="{{ asset('images/login-illustration.png') }}" alt="Ilustrasi Admin" class="relative w-full rounded-2xl float-animation">
                </div>
            </div>

            {{-- Bottom Info --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-amber-400 border-2 border-emerald-900 flex items-center justify-center text-[10px] font-bold text-white">S</div>
                        <div class="w-8 h-8 rounded-full bg-emerald-400 border-2 border-emerald-900 flex items-center justify-center text-[10px] font-bold text-white">A</div>
                        <div class="w-8 h-8 rounded-full bg-blue-400 border-2 border-emerald-900 flex items-center justify-center text-[10px] font-bold text-white">R</div>
                    </div>
                    <p class="text-emerald-100/80 text-xs">Dipercaya oleh 500+ keluarga di Kab. Bogor</p>
                </div>
                <p class="text-emerald-300/40 text-[11px]">&copy; {{ date('Y') }} Sekolah 'Aqila. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>

    {{-- Right Side: Login Form --}}
    <div class="flex-1 flex items-center justify-center bg-gray-50 p-6 sm:p-12 relative">
        {{-- Subtle decorative element --}}
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-amber-100/50 to-transparent rounded-bl-full"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-emerald-50 to-transparent rounded-tr-full"></div>

        <div class="w-full max-w-md relative z-10">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo-tkaqila.png') }}" alt="Logo TK Aqila" class="w-10 h-10 rounded-xl object-cover">
                <div>
                    <p class="font-bold text-gray-900 text-lg">Sekolah 'Aqila</p>
                    <p class="text-xs text-gray-400">KB & TKIT • Kab. Bogor</p>
                </div>
            </div>

            {{-- Welcome Text --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang! 👋</h1>
                <p class="text-sm text-gray-500">Masuk ke dashboard admin untuk mengelola pendaftaran peserta didik baru.</p>
            </div>

            {{-- Error Message --}}
            @if(session('error'))
                <div class="mb-6 rounded-xl bg-red-50 text-red-600 px-4 py-3 text-sm flex items-center gap-2.5 border border-red-100">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ url('/loginadmin') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="admin@aqila.local"
                               class="input-field w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-emerald-500 focus:ring-0 text-sm outline-none placeholder-gray-300">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="input-field w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-emerald-500 focus:ring-0 text-sm outline-none placeholder-gray-300">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/40 transition-all duration-200 active:scale-[0.98]">
                    Masuk ke Dashboard
                </button>
            </form>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>

            {{-- Info Badge --}}
            <div class="mt-8 rounded-xl bg-emerald-50/80 border border-emerald-100 p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-emerald-800">Halaman khusus admin</p>
                    <p class="text-[11px] text-emerald-600/70 mt-0.5">Halaman ini hanya dapat diakses oleh pengelola TK Aqila. Hubungi admin jika Anda membutuhkan akses.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
