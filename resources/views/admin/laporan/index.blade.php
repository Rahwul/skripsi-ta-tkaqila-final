@extends('layouts.admin')

@section('title', 'Laporan Pendaftaran | TK Aqila')
@section('page_title', 'Laporan Pendaftaran')
@section('page_subtitle', 'Rekap pendaftaran berdasarkan periode tanggal')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid gap-4 md:grid-cols-3 items-end text-xs sm:text-sm">
            <div>
                <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}"
                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}"
                       class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs">
            </div>
            <div>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full bg-[#4F46E5] hover:bg-[#4338CA] text-white text-xs font-semibold shadow-md hover:shadow-lg transition-all w-full">
                    Tampilkan Laporan
                </button>
            </div>
        </form>
        @if ($error)
            <div class="mt-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                {{ $error }}
            </div>
        @endif
    </div>

    @if ($laporan)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between text-xs sm:text-sm">
                <div>
                    <p class="font-semibold text-[#111827]">Periode</p>
                    <p class="text-[#6B7280]">
                        {{ $laporan['start_date'] ?? '' }} s/d {{ $laporan['end_date'] ?? '' }}
                        · Total: <span class="font-semibold text-[#111827]">{{ $laporan['total'] ?? 0 }}</span> pendaftar
                    </p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left">
                    <thead class="bg-gray-50 text-[#6B7280]">
                        <tr>
                            <th class="px-4 py-3 font-medium">Nama Anak</th>
                            <th class="px-4 py-3 font-medium">Orang Tua</th>
                            <th class="px-4 py-3 font-medium">Tgl Daftar</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach (($laporan['data'] ?? []) as $p)
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
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-[#111827] font-medium">{{ $p['nama_anak'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#374151]">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#6B7280]">{{ $p['created_at'] ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $s['bg'] }}">
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

