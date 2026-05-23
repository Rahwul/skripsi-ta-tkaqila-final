@extends('layouts.admin')

@section('title', 'Jadwal Kelas | TK Aqila')
@section('page_title', 'Jadwal Kelas')
@section('page_subtitle', 'Kelola jadwal kelas TK Aqila')

@section('content')
    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 flex items-center gap-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    @if ($error)
        <div class="mb-4 flex items-center gap-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">{{ $error }}</div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Table --}}
        <div class="lg:col-span-2 rounded-lg border border-zinc-200 bg-white shadow-sm">
            <form id="bulkJadwalForm" action="{{ route('admin.jadwal.bulkDestroy') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100">
                    <h2 class="text-sm font-semibold text-zinc-900">Daftar Jadwal</h2>
                    <button type="button" id="bulkJadwalDeleteBtn"
                            class="inline-flex items-center h-8 px-3 rounded-md bg-white text-red-600 border border-red-200 text-xs font-medium shadow-sm hover:bg-red-50 transition-colors">
                        Hapus Terpilih
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50/50">
                            <th class="px-4 py-2.5 w-10">
                                <input id="jadwalSelectAll" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                            </th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Kelas</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Hari</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Jam</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Keterangan</th>
                            <th class="px-4 py-2.5 text-xs font-medium text-zinc-500 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($jadwal as $j)
                            <tr class="hover:bg-zinc-50/80 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" name="ids[]" value="{{ $j['id'] }}" class="jadwalRowCheckbox h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                                </td>
                                <td class="px-4 py-2.5 font-medium text-zinc-900">{{ $j['nama_kelas'] ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-zinc-600">{{ $j['hari'] ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-zinc-500 text-xs font-mono">
                                    {{ $j['jam_mulai'] ?? '-' }} – {{ $j['jam_selesai'] ?? '-' }}
                                </td>
                                <td class="px-4 py-2.5 text-xs text-zinc-500">{{ $j['keterangan'] ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-right">
                                    <form action="{{ route('admin.jadwal.destroy', $j['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-800 transition-colors"
                                                onclick="return confirm('Hapus jadwal ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-400 text-sm">
                                    Belum ada jadwal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>
        </div>

        {{-- Form --}}
        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-4">
            <h2 class="text-sm font-semibold text-zinc-900 mb-3">Tambah Jadwal</h2>
            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                           class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Hari</label>
                    <input type="text" name="hari" placeholder="Contoh: Senin – Rabu"
                           class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-zinc-600 mb-1">Jam Mulai</label>
                        <input type="text" name="jam_mulai" placeholder="08:00"
                               class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-600 mb-1">Jam Selesai</label>
                        <input type="text" name="jam_selesai" placeholder="10:00"
                               class="w-full h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                              class="w-full px-2.5 py-1.5 rounded-md border border-zinc-200 bg-white text-sm shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none resize-none"></textarea>
                </div>
                @if ($errors->has('global'))
                    <p class="text-xs text-red-600">{{ $errors->first('global') }}</p>
                @endif
                <button type="submit"
                        class="w-full inline-flex items-center justify-center h-8 px-3 rounded-md bg-zinc-900 text-white text-xs font-medium shadow-sm hover:bg-zinc-800 transition-colors">
                    Simpan Jadwal
                </button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var form = document.getElementById('bulkJadwalForm');
            var selectAll = document.getElementById('jadwalSelectAll');
            var deleteBtn = document.getElementById('bulkJadwalDeleteBtn');

            function boxes() { return Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]')); }
            function checkedBoxes() { return Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]:checked')); }

            function syncSelectAll() {
                if (!selectAll) return;
                var all = boxes(), checked = checkedBoxes();
                selectAll.checked = all.length > 0 && checked.length === all.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    var all = boxes();
                    for (var i = 0; i < all.length; i++) all[i].checked = selectAll.checked;
                    syncSelectAll();
                });
            }

            document.addEventListener('change', function (e) {
                if (e.target && e.target.classList && e.target.classList.contains('jadwalRowCheckbox')) syncSelectAll();
            });

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function () {
                    if (!form) return;
                    if (checkedBoxes().length === 0) return;
                    if (!confirm('Hapus semua jadwal yang dipilih?')) return;
                    form.submit();
                });
            }

            syncSelectAll();
        })();
    </script>
@endsection
