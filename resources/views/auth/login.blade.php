<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | TK Aqila</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F3F8FF] flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Blobs -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="blob bg-blue-300/30 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-yellow-200/40 w-80 h-80 rounded-full bottom-0 right-0 translate-x-1/3 translate-y-1/3 animation-delay-2000"></div>
    </div>

    <div class="w-full max-w-5xl grid md:grid-cols-2 gap-8 items-center relative z-10">
        <!-- Left Side: Illustration & Welcome -->
        <div class="hidden md:flex flex-col justify-center space-y-6 p-6">
            <div class="relative w-full aspect-square max-w-md mx-auto">
                <div class="absolute inset-0 bg-linear-to-tr from-blue-400 to-blue-600 rounded-[2.5rem] rotate-3 shadow-2xl shadow-blue-500/20 opacity-90"></div>
                <div class="absolute inset-0 bg-white rounded-[2.5rem] -rotate-2 border-4 border-blue-100 flex items-center justify-center overflow-hidden">
                     <!-- Playful SVG Pattern -->
                     <svg class="w-full h-full opacity-10" viewBox="0 0 100 100" fill="currentColor">
                        <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" class="text-blue-300" />
                        </pattern>
                        <rect width="100" height="100" fill="url(#grid)" />
                     </svg>
                     <div class="text-center p-8 relative z-10">
                        <div class="w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center text-4xl mb-4 mx-auto shadow-lg shadow-yellow-400/30 animate-bounce">
                            👋
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                        <p class="text-gray-500">Silakan login untuk mengakses dashboard pendaftaran TK Aqila.</p>
                     </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="glass p-8 md:p-12 rounded-4xl shadow-xl shadow-blue-900/5 w-full max-w-md mx-auto relative">
            <div class="absolute -top-6 -right-6 w-16 h-16 bg-yellow-400 rounded-full blur-xl opacity-60"></div>
            
            <div class="text-center mb-10">
                <a href="/" class="inline-flex items-center gap-2 mb-2 group">
                    <div class="w-8 h-8 brand-bg rounded-lg flex items-center justify-center text-white font-bold group-hover:scale-110 transition-transform">A</div>
                    <span class="font-bold text-xl text-gray-800 group-hover:brand-text transition-colors">TK Aqila</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Login Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Masuk untuk mengelola data pendaftaran</p>
            </div>

            @if(session('error'))
                <div class="mb-6 rounded-2xl bg-red-50 text-red-600 px-4 py-3 text-sm flex items-center gap-2 border border-red-100">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 text-red-600 px-4 py-3 text-sm flex items-center gap-2 border border-red-100">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                            placeholder="admin@aqila.local">
                        <div class="absolute right-4 top-3.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 ml-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required 
                            class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                            placeholder="••••••••">
                        <div class="absolute right-4 top-3.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl btn-primary font-bold shadow-lg hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-200">
                    Masuk Sekarang
                </button>

                <div class="text-center mt-6">
                    <a href="/" class="text-sm text-gray-500 hover:text-blue-600 font-medium transition-colors">← Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
