@extends('layouts.admin')

@section('title', 'Detail Pendaftar | TK Aqila')
@section('page_title', 'Detail Pendaftar')
@section('page_subtitle', 'Informasi lengkap dan status pendaftaran')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <a href="{{ route('admin.pendaftar.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 rounded-full border border-gray-200 bg-white text-xs font-semibold text-[#111827] shadow-sm hover:bg-gray-50">
            ← Kembali
        </a>

        <form action="{{ route('admin.pendaftar.destroy', $pendaftar['id']) }}" method="POST"
              onsubmit="return confirm('Hapus data pendaftar ini?')">
            @csrf
            <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm">
                Hapus
            </button>
        </form>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mb-8">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-sm font-semibold text-[#111827] mb-3">Data Anak</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-[#374151]">
                    <div>
                        <dt class="text-[#6B7280]">Nama Lengkap</dt>
                        <dd class="font-semibold">{{ $pendaftar['nama_anak'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#6B7280]">Tempat, Tanggal Lahir</dt>
                        <dd class="font-semibold">
                            {{ $pendaftar['tempat_lahir'] ?? '-' }},
                            {{ $pendaftar['tanggal_lahir'] ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-[#6B7280]">Jenis Kelamin</dt>
                        <dd class="font-semibold">{{ $pendaftar['jenis_kelamin'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#6B7280]">Tanggal Daftar</dt>
                        <dd class="font-semibold">{{ $pendaftar['created_at'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-sm font-semibold text-[#111827] mb-3">Data Orang Tua / Wali</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-[#374151]">
                    <div>
                        <dt class="text-[#6B7280]">Nama Orang Tua / Wali</dt>
                        <dd class="font-semibold">{{ $pendaftar['nama_orang_tua'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#6B7280]">No. HP</dt>
                        <dd class="font-semibold">{{ $pendaftar['no_hp'] ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-[#6B7280]">Alamat</dt>
                        <dd class="font-semibold">{{ $pendaftar['alamat'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-sm font-semibold text-[#111827] mb-3">Status Pendaftaran</h2>
                @php
                    $status = $pendaftar['status_pendaftaran'] ?? 'pending';
                    $map = [
                        'pending'  => ['bg' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending'],
                        'diproses' => ['bg' => 'bg-blue-100 text-blue-800', 'label' => 'Diproses'],
                        'diterima' => ['bg' => 'bg-green-100 text-green-800', 'label' => 'Diterima'],
                        'ditolak'  => ['bg' => 'bg-red-100 text-red-800', 'label' => 'Ditolak'],
                    ];
                    $s = $map[$status] ?? $map['pending'];
                @endphp
                <p class="mb-2 text-xs text-[#6B7280]">Status saat ini:</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $s['bg'] }}">
                    {{ $s['label'] }}
                </span>
                <p class="mt-3 text-xs text-[#6B7280]">Catatan:</p>
                <p class="text-xs font-medium text-[#374151]">{{ $pendaftar['catatan'] ?? '-' }}</p>

                <form action="{{ route('admin.pendaftar.updateStatus', $pendaftar['id']) }}" method="POST" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Ubah Status</label>
                        <select name="status_pendaftaran"
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-xs outline-none">
                            @foreach (['pending','diproses','diterima','ditolak'] as $opt)
                                <option value="{{ $opt }}" @selected($status === $opt)>{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Catatan (opsional)</label>
                        <textarea name="catatan" rows="2"
                                  class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-xs outline-none">{{ $pendaftar['catatan'] ?? '' }}</textarea>
                    </div>
                    @if ($errors->has('global'))
                        <p class="text-xs text-red-600">{{ $errors->first('global') }}</p>
                    @endif
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-[#4F46E5] hover:bg-[#4338CA] text-white text-xs font-semibold shadow-md hover:shadow-lg transition-all">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
