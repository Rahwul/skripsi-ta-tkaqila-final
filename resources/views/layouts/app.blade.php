<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TK Aqila - Pendaftaran Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-[#F9FAFB] text-[#111827] flex flex-col">
    <x-navbar />

    {{-- Flash alerts (opsional, untuk halaman yang butuh) --}}
    @if (session('success') || session('error') || $errors->any())
        <div class="max-w-3xl mx-auto w-full px-4 mt-4 space-y-2">
            @if (session('success'))
                <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow-sm">
                    <span class="mt-0.5 font-bold">OK</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm">
                    <span class="mt-0.5 font-bold">!</span>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm">
                    <span class="mt-0.5">!</span>
                    <div>
                        <p class="font-semibold mb-1">Terjadi kesalahan pada form:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Main content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>

