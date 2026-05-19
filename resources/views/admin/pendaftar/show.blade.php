@extends('layouts.admin')

@section('title', 'Detail Pendaftar | TK Aqila')
@section('page_title', 'Detail Pendaftar')
@section('page_subtitle', 'Informasi lengkap dan status pendaftaran')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <a href="{{ route('admin.pendaftar.index') }}"
           class="inline-flex items-center gap-1.5 h-8 px-3 rounded-md border border-zinc-200 bg-white text-xs font-medium text-zinc-700 shadow-sm hover:bg-zinc-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <form action="{{ route('admin.pendaftar.destroy', $pendaftar['id']) }}" method="POST"
              onsubmit="return confirm('Hapus data pendaftar ini?')">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-1.5 h-8 px-3 rounded-md bg-white text-red-600 border border-red-200 text-xs font-medium shadow-sm hover:bg-red-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus
            </button>
        </form>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            {{-- Data Anak --}}
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-4">
                <h2 class="text-sm font-semibold text-zinc-900 mb-3">Data Anak</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">Nama Lengkap</dt>
                        <dd class="font-medium text-zinc-900">{{ $pendaftar['nama_anak'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">Tempat, Tanggal Lahir</dt>
                        <dd class="font-medium text-zinc-900">
                            {{ $pendaftar['tempat_lahir'] ?? '-' }},
                            {{ $pendaftar['tanggal_lahir'] ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">Jenis Kelamin</dt>
                        <dd class="font-medium text-zinc-900">{{ $pendaftar['jenis_kelamin'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">Tanggal Daftar</dt>
                        <dd class="font-medium text-zinc-900">{{ $pendaftar['created_at'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Data Orang Tua --}}
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-4">
                <h2 class="text-sm font-semibold text-zinc-900 mb-3">Data Orang Tua / Wali</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">Nama Orang Tua / Wali</dt>
                        <dd class="font-medium text-zinc-900">{{ $pendaftar['nama_orang_tua'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-500 mb-0.5">No. HP</dt>
                        <dd class="font-medium text-zinc-900 font-mono">{{ $pendaftar['no_hp'] ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs text-zinc-500 mb-0.5">Alamat</dt>
                        <dd class="font-medium text-zinc-900">{{ $pendaftar['alamat'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Status & Action --}}
        <div>
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-4">
                <h2 class="text-sm font-semibold text-zinc-900 mb-3">Status Pendaftaran</h2>
                @php
                    $status = $pendaftar['status_pendaftaran'] ?? 'pending';
                    $map = [
                        'pending'  => ['cls' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20', 'label' => 'Pending'],
                        'diproses' => ['cls' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', 'label' => 'Diproses'],
                        'diterima' => ['cls' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'label' => 'Diterima'],
                        'ditolak'  => ['cls' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', 'label' => 'Ditolak'],
                    ];
                    $s = $map[$status] ?? $map['pending'];
                @endphp
                <p class="text-xs text-zinc-500 mb-1.5">Status saat ini:</p>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $s['cls'] }}">
                    {{ $s['label'] }}
                </span>
                <p class="mt-3 text-xs text-zinc-500">Catatan:</p>
                <p class="text-sm text-zinc-700 mt-0.5">{{ $pendaftar['catatan'] ?? '-' }}</p>

                <hr class="my-4 border-zinc-100">

                <form action="{{ route('admin.pendaftar.updateStatus', $pendaftar['id']) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-zinc-600 mb-1">Ubah Status</label>
                        <select name="status_pendaftaran"
                                class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm text-zinc-700 shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                            @foreach (['pending','diproses','diterima','ditolak'] as $opt)
                                <option value="{{ $opt }}" @selected($status === $opt)>{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-600 mb-1">Catatan (opsional)</label>
                        <textarea name="catatan" rows="2"
                                  class="w-full px-2.5 py-1.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none resize-none">{{ $pendaftar['catatan'] ?? '' }}</textarea>
                    </div>
                    @if ($errors->has('global'))
                        <p class="text-xs text-red-600">{{ $errors->first('global') }}</p>
                    @endif
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center h-8 px-3 rounded-md bg-zinc-900 text-white text-xs font-medium shadow-sm hover:bg-zinc-800 transition-colors">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
