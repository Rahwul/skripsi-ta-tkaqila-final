@extends('layouts.admin')

@section('title', 'Dashboard Admin | TK Aqila')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan pendaftaran peserta didik baru')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card :value="$stat['total']" label="Total Pendaftar" tone="emerald" />
        <x-stat-card :value="$stat['pending']" label="Pending" tone="amber" />
        <x-stat-card :value="$stat['diproses']" label="Diproses" tone="blue" />
        <x-stat-card :value="$stat['diterima']" label="Diterima" tone="green" />
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100">
            <h2 class="text-sm font-semibold text-zinc-900">Pendaftaran Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50/50">
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Nama Anak</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Orang Tua</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Tanggal</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Status</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($recent as $p)
                        <tr class="hover:bg-zinc-50/80 transition-colors">
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-zinc-100 text-zinc-600 flex items-center justify-center text-xs font-semibold">
                                        {{ strtoupper(substr($p['nama_anak'] ?? 'A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900 text-sm">{{ $p['nama_anak'] ?? '-' }}</p>
                                        <p class="text-[11px] text-zinc-400">ID: {{ $p['id'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-zinc-600">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                            <td class="px-4 py-2.5 text-zinc-500 text-xs">{{ $p['created_at'] ?? '-' }}</td>
                            <td class="px-4 py-2.5">
                                @php
                                    $status = $p['status_pendaftaran'] ?? 'pending';
                                    $map = [
                                        'pending'  => ['cls' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20', 'label' => 'Pending'],
                                        'diproses' => ['cls' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', 'label' => 'Diproses'],
                                        'diterima' => ['cls' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'label' => 'Diterima'],
                                        'ditolak'  => ['cls' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', 'label' => 'Ditolak'],
                                    ];
                                    $s = $map[$status] ?? $map['pending'];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium {{ $s['cls'] }}">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 text-right">
                                <a href="{{ route('admin.pendaftar.show', $p['id']) }}"
                                   class="text-xs font-medium text-emerald-600 hover:text-emerald-800 transition-colors">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-zinc-400 text-sm">
                                Belum ada pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
