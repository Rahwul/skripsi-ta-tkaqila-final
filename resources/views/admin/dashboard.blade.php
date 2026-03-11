@extends('layouts.admin')

@section('title', 'Dashboard Admin | TK Aqila')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan pendaftaran peserta didik baru')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <x-stat-card :value="$stat['total']" label="Total Pendaftar" tone="indigo" />
        <x-stat-card :value="$stat['pending']" label="Pending" tone="amber" />
        <x-stat-card :value="$stat['diproses']" label="Diproses" tone="indigo" />
        <x-stat-card :value="$stat['diterima']" label="Diterima" tone="green" />
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Pendaftaran Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm text-left">
                <thead class="bg-gray-50 text-[#6B7280]">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Anak</th>
                        <th class="px-4 py-3 font-medium">Orang Tua</th>
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recent as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($p['nama_anak'] ?? 'A', 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-[#111827]">{{ $p['nama_anak'] ?? '-' }}</span>
                                        <span class="text-[11px] text-[#6B7280]">ID: {{ $p['id'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#374151]">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-[#6B7280]">{{ $p['created_at'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $status = $p['status_pendaftaran'] ?? 'pending';
                                    $map = [
                                        'pending'  => ['bg' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending'],
                                        'diproses' => ['bg' => 'bg-blue-100 text-blue-800', 'label' => 'Diproses'],
                                        'diterima' => ['bg' => 'bg-green-100 text-green-800', 'label' => 'Diterima'],
                                        'ditolak'  => ['bg' => 'bg-red-100 text-red-800', 'label' => 'Ditolak'],
                                    ];
                                    $s = $map[$status] ?? $map['pending'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $s['bg'] }}">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.pendaftar.show', $p['id']) }}"
                                   class="text-xs font-semibold text-[#4F46E5] hover:text-[#4338CA]">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[#6B7280] text-sm">
                                Belum ada pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

