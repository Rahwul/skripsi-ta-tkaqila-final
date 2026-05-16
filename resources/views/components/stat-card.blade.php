@props([
    'value' => '0',
    'label' => '',
    'tone' => 'emerald',
    'icon' => null,
])

@php
    $toneMap = [
        'emerald' => ['ring' => 'ring-emerald-500/20', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
        'green'   => ['ring' => 'ring-emerald-500/20', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
        'amber'   => ['ring' => 'ring-amber-500/20', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'dot' => 'bg-amber-500'],
        'blue'    => ['ring' => 'ring-blue-500/20', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'dot' => 'bg-blue-500'],
        'rose'    => ['ring' => 'ring-rose-500/20', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'dot' => 'bg-rose-500'],
        'indigo'  => ['ring' => 'ring-emerald-500/20', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
    ];
    $t = $toneMap[$tone] ?? $toneMap['emerald'];
@endphp

<div class="rounded-lg border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between mb-2">
        <p class="text-xs font-medium text-zinc-500">{{ $label }}</p>
        <div class="h-2 w-2 rounded-full {{ $t['dot'] }}"></div>
    </div>
    <p class="text-2xl font-bold tracking-tight {{ $t['text'] }}">{{ $value }}</p>
</div>
