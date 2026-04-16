@props([
    'value' => '0',
    'label' => '',
    'tone' => 'indigo', // indigo|green|amber|rose
])

@php
    $toneMap = [
        'indigo' => ['bg' => 'bg-[#EEF2FF]', 'text' => 'text-[#4F46E5]'],
        'green'  => ['bg' => 'bg-[#ECFDF5]', 'text' => 'text-[#10B981]'],
        'amber'  => ['bg' => 'bg-[#FFFBEB]', 'text' => 'text-[#F59E0B]'],
        'rose'   => ['bg' => 'bg-[#FFF1F2]', 'text' => 'text-[#EF4444]'],
    ];
    $t = $toneMap[$tone] ?? $toneMap['indigo'];
@endphp

<div class="rounded-2xl bg-white border border-gray-100 shadow-sm px-5 py-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl {{ $t['bg'] }} flex items-center justify-center">
            <div class="w-2.5 h-2.5 rounded-full {{ $t['text'] }} bg-current/20"></div>
        </div>
        <div class="leading-tight">
            <p class="text-lg font-extrabold tracking-tight {{ $t['text'] }}">{{ $value }}</p>
            <p class="text-[11px] text-[#6B7280]">{{ $label }}</p>
        </div>
    </div>
</div>

