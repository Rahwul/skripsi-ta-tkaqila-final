@extends('layouts.admin')

@section('title', 'Konten Website | TK Aqila')
@section('page_title', 'Konten Website')
@section('page_subtitle', 'Kelola isi konten landing page')

@section('content')
    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 flex items-center gap-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($error)
        <div class="mb-4 flex items-center gap-2 rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-700">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            {{ $error }}
        </div>
    @endif

    @php
        // Group fields by section for clean layout
        $sections = [
            'Hero Section' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z', 'desc' => 'Bagian utama yang pertama kali dilihat pengunjung.', 'keys' => ['landing.hero_badge', 'landing.hero_title_line1', 'landing.hero_title_highlight', 'landing.hero_description']],
            'Keunggulan' => ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Poin keunggulan yang ditampilkan di hero section.', 'keys' => ['landing.feature_1', 'landing.feature_2']],
            'Statistik' => ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'desc' => 'Angka-angka pencapaian yang ditampilkan di landing page.', 'keys' => ['landing.stats_alumni', 'landing.stats_pengalaman', 'landing.stats_guru', 'landing.stats_kepuasan']],
            'Tentang Kami' => ['icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Informasi profil dan deskripsi sekolah.', 'keys' => ['landing.about_heading', 'landing.about_heading_highlight', 'landing.about_description']],
        ];

        // Build lookup from fields array
        $fieldLookup = [];
        foreach ($fields as $f) {
            $fieldLookup[$f['key']] = $f;
        }
    @endphp

    <form action="{{ route('admin.konten.update') }}" method="POST">
        @csrf
        <div class="max-w-4xl space-y-4">
            @foreach ($sections as $sectionName => $section)
                <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
                    {{-- Section Header --}}
                    <div class="flex items-center gap-3 px-4 py-3 border-b border-zinc-100 bg-zinc-50/50">
                        <div class="flex items-center justify-center w-7 h-7 rounded-md bg-zinc-100 text-zinc-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $section['icon'] }}"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-zinc-900">{{ $sectionName }}</h2>
                            <p class="text-[11px] text-zinc-500">{{ $section['desc'] }}</p>
                        </div>
                    </div>

                    {{-- Section Fields --}}
                    <div class="p-4">
                        @php
                            $isStats = $sectionName === 'Statistik';
                        @endphp

                        <div class="{{ $isStats ? 'grid grid-cols-2 sm:grid-cols-4 gap-3' : 'space-y-3' }}">
                            @foreach ($section['keys'] as $key)
                                @php
                                    $f = $fieldLookup[$key] ?? null;
                                    if (!$f) continue;
                                    $value = $content[$key] ?? '';
                                    $isLong = str_contains($key, 'description') || str_contains($key, 'feature');
                                @endphp

                                <div>
                                    <label class="block text-xs font-medium text-zinc-700 mb-1">{{ $f['label'] }}</label>
                                    @if ($isLong)
                                        <textarea name="content[{{ $key }}]" rows="3"
                                                  class="w-full px-2.5 py-1.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none resize-none placeholder:text-zinc-300"
                                                  placeholder="{{ $f['label'] }}">{{ $value }}</textarea>
                                    @else
                                        <input type="text" name="content[{{ $key }}]" value="{{ $value }}"
                                               class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none placeholder:text-zinc-300"
                                               placeholder="{{ $f['label'] }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Fields not in any section (fallback) --}}
            @php
                $allGroupedKeys = collect($sections)->pluck('keys')->flatten()->toArray();
                $ungrouped = array_filter($fields, fn($f) => !in_array($f['key'], $allGroupedKeys));
            @endphp

            @if (count($ungrouped) > 0)
                <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-zinc-100 bg-zinc-50/50">
                        <h2 class="text-sm font-semibold text-zinc-900">Lainnya</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        @foreach ($ungrouped as $f)
                            @php
                                $key = $f['key'];
                                $value = $content[$key] ?? '';
                                $isLong = str_contains($key, 'description') || str_contains($key, 'feature');
                            @endphp
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 mb-1">{{ $f['label'] }}</label>
                                @if ($isLong)
                                    <textarea name="content[{{ $key }}]" rows="3"
                                              class="w-full px-2.5 py-1.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none resize-none placeholder:text-zinc-300"
                                              placeholder="{{ $f['label'] }}">{{ $value }}</textarea>
                                @else
                                    <input type="text" name="content[{{ $key }}]" value="{{ $value }}"
                                           class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none placeholder:text-zinc-300"
                                           placeholder="{{ $f['label'] }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center h-9 px-4 rounded-md bg-zinc-900 text-white text-sm font-medium shadow-sm hover:bg-zinc-800 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <p class="text-[11px] text-zinc-400">Perubahan akan langsung tampil di landing page.</p>
            </div>
        </div>
    </form>
@endsection
