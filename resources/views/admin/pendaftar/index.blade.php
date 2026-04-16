@extends('layouts.admin')

@section('title', 'Data Pendaftar | TK Aqila')
@section('page_title', 'Data Pendaftar')
@section('page_subtitle', 'Kelola data pendaftar peserta didik baru')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($error)
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $error }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form id="bulkForm" action="{{ route('admin.pendaftar.bulk') }}" method="POST">
            @csrf
            <input type="hidden" name="action" id="bulkAction" value="">

            <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Daftar Pendaftar</h2>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <select name="status_pendaftaran" id="bulkStatus"
                            class="px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-xs outline-none">
                        <option value="pending">Pending</option>
                        <option value="diproses">Diproses</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <div class="flex items-center gap-2">
                        <button type="button" id="bulkUpdateBtn"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-[#4F46E5] hover:bg-[#4338CA] text-white text-xs font-semibold shadow-sm">
                            Ubah Status
                        </button>
                        <button type="button" id="bulkDeleteBtn"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left">
                <thead class="bg-gray-50 text-[#6B7280]">
                    <tr>
                        <th class="px-4 py-3 font-medium w-10">
                            <input id="selectAll" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                        </th>
                        <th class="px-4 py-3 font-medium">Nama Anak</th>
                        <th class="px-4 py-3 font-medium">Orang Tua</th>
                        <th class="px-4 py-3 font-medium">No. HP</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pendaftar as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids[]" value="{{ $p['id'] }}" class="rowCheckbox h-4 w-4 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($p['nama_anak'] ?? 'A', 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-[#111827]">{{ $p['nama_anak'] ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#374151]">{{ $p['nama_orang_tua'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-[#6B7280]">{{ $p['no_hp'] ?? '-' }}</td>
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
                            <td colspan="6" class="px-4 py-6 text-center text-[#6B7280] text-sm">
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
