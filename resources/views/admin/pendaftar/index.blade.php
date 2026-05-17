@extends('layouts.admin')

@section('title', 'Data Pendaftar | TK Aqila')
@section('page_title', 'Data Pendaftar')
@section('page_subtitle', 'Kelola data pendaftar peserta didik baru')

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
        <div class="mb-4 flex items-center gap-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $error }}
        </div>
    @endif

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm">
        <form id="bulkForm" action="{{ route('admin.pendaftar.bulk') }}" method="POST">
            @csrf
            <input type="hidden" name="action" id="bulkAction" value="">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100">
                <h2 class="text-sm font-semibold text-zinc-900">Daftar Pendaftar</h2>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <select name="status_pendaftaran" id="bulkStatus"
                            class="h-8 px-2.5 rounded-md border border-zinc-200 bg-white text-xs text-zinc-700 shadow-sm focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 outline-none">
                        <option value="pending">Pending</option>
                        <option value="diproses">Diproses</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <div class="flex items-center gap-1.5">
                        <button type="button" id="bulkUpdateBtn"
                                class="inline-flex items-center h-8 px-3 rounded-md bg-zinc-900 text-white text-xs font-medium shadow-sm hover:bg-zinc-800 transition-colors">
                            Ubah Status
                        </button>
                        <button type="button" id="bulkDeleteBtn"
                                class="inline-flex items-center h-8 px-3 rounded-md bg-white text-red-600 border border-red-200 text-xs font-medium shadow-sm hover:bg-red-50 transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50/50">
                        <th class="px-4 py-2.5 w-10">
                            <input id="selectAll" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                        </th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Nama Anak</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Orang Tua</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">No. HP</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500">Status</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-zinc-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($pendaftar as $p)
                        <tr class="hover:bg-zinc-50/80 transition-colors">
                            <td class="px-4 py-2.5">
                                <input type="checkbox" name="ids[]" value="{{ $p['id'] }}" class="rowCheckbox h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                            </td>
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-zinc-100 text-zinc-600 flex items-center justify-center text-xs font-semibold">
                                        {{ strtoupper(substr($p['nama_anak'] ?? 'A', 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-zinc-900">{{ $p['nama_anak'] ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-zinc-600">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                            <td class="px-4 py-2.5 text-zinc-500 text-xs font-mono">{{ $p['no_hp'] ?? '-' }}</td>
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
                            <td colspan="6" class="px-4 py-8 text-center text-zinc-400 text-sm">
                                Belum ada data pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </form>
    </div>

    <script>
        (function () {
            var bulkForm = document.getElementById('bulkForm');
            var bulkAction = document.getElementById('bulkAction');
            var selectAll = document.getElementById('selectAll');
            var updateBtn = document.getElementById('bulkUpdateBtn');
            var deleteBtn = document.getElementById('bulkDeleteBtn');

            function checkedBoxes() {
                return Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]:checked'));
            }

            function syncSelectAll() {
                if (!selectAll) return;
                var boxes = Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]'));
                var checked = boxes.filter(function (b) { return b.checked; });
                selectAll.checked = boxes.length > 0 && checked.length === boxes.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < boxes.length;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    var boxes = document.querySelectorAll('input[name="ids[]"]');
                    for (var i = 0; i < boxes.length; i++) {
                        boxes[i].checked = selectAll.checked;
                    }
                    syncSelectAll();
                });
            }

            document.addEventListener('change', function (e) {
                if (e.target && e.target.classList && e.target.classList.contains('rowCheckbox')) {
                    syncSelectAll();
                }
            });

            function submitBulk(action) {
                if (!bulkForm || !bulkAction) return;
                if (checkedBoxes().length === 0) return;
                bulkAction.value = action;
                bulkForm.submit();
            }

            if (updateBtn) {
                updateBtn.addEventListener('click', function () {
                    submitBulk('update_status');
                });
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function () {
                    if (!confirm('Hapus semua data yang dipilih?')) return;
                    submitBulk('delete');
                });
            }

            syncSelectAll();
        })();
    </script>
@endsection
