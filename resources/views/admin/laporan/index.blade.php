@extends('layouts.admin')

@section('title', 'Laporan Pendaftaran | TK Aqila')
@section('page_title', 'Laporan Pendaftaran')
@section('page_subtitle', 'Rekap pendaftaran berdasarkan periode tanggal')

@section('content')
    {{-- Filter --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-4 mb-4">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid gap-3 md:grid-cols-3 items-end">
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}"
                       class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}"
                       class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
            </div>
            <div>
                <button type="submit"
                        class="w-full inline-flex items-center justify-center h-8 px-3 rounded-md bg-zinc-900 text-white text-sm font-medium shadow-sm hover:bg-zinc-800 transition-colors">
                    Tampilkan Laporan
                </button>
            </div>
        </form>
        @if ($error)
            <div class="mt-3 flex items-center gap-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">{{ $error }}</div>
        @endif
    </div>

    {{-- Results --}}
    @if ($laporan)
        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100">
                <div>
                    <p class="text-sm font-semibold text-zinc-900">Periode</p>
                    <p class="text-xs text-zinc-500">
                        {{ $laporan['start_date'] ?? '' }} s/d {{ $laporan['end_date'] ?? '' }}
                        · Total: <span class="font-semibold text-zinc-900">{{ $laporan['total'] ?? 0 }}</span> pendaftar
                    </p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50/50">
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Nama Anak</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Orang Tua</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Tgl Daftar</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach (($laporan['data'] ?? []) as $p)
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
                            <tr class="hover:bg-zinc-50/80 transition-colors">
                                <td class="px-4 py-2.5 font-medium text-zinc-900">{{ $p['nama_anak'] ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-zinc-600">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-zinc-500 text-xs">{{ $p['created_at'] ?? '-' }}</td>
                                <td class="px-4 py-2.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium {{ $s['cls'] }}">
                                        {{ $s['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
