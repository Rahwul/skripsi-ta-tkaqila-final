@extends('layouts.admin')

@section('title', 'Jadwal Kelas | TK Aqila')
@section('page_title', 'Jadwal Kelas')
@section('page_subtitle', 'Kelola jadwal kelas TK Aqila')

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

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form id="bulkJadwalForm" action="{{ route('admin.jadwal.bulkDestroy') }}" method="POST">
                @csrf
                <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Daftar Jadwal</h2>
                    <button type="button" id="bulkJadwalDeleteBtn"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm">
                        Hapus Terpilih
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs sm:text-sm text-left">
                    <thead class="bg-gray-50 text-[#6B7280]">
                        <tr>
                            <th class="px-4 py-3 font-medium w-10">
                                <input id="jadwalSelectAll" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                            </th>
                            <th class="px-4 py-3 font-medium">Kelas</th>
                            <th class="px-4 py-3 font-medium">Hari</th>
                            <th class="px-4 py-3 font-medium">Jam</th>
                            <th class="px-4 py-3 font-medium">Keterangan</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($jadwal as $j)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="ids[]" value="{{ $j['id'] }}" class="jadwalRowCheckbox h-4 w-4 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                </td>
                                <td class="px-4 py-3 font-semibold text-[#111827]">{{ $j['nama_kelas'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#374151]">{{ $j['hari'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#6B7280]">
                                    {{ $j['jam_mulai'] ?? '-' }} - {{ $j['jam_selesai'] ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-[11px] text-[#6B7280]">
                                    {{ $j['keterangan'] ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.jadwal.destroy', $j['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-[11px] text-red-600 hover:text-red-700 ml-2"
                                                onclick="return confirm('Hapus jadwal ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-[#6B7280] text-sm">
                                    Belum ada jadwal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-sm font-semibold text-[#111827] mb-3">Tambah / Ubah Jadwal</h2>
            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-3 text-xs sm:text-sm">
                @csrf
                <div>
                    <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                           class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Hari</label>
                    <input type="text" name="hari"
                           class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs"
                           placeholder="Contoh: Senin - Rabu">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Jam Mulai</label>
                        <input type="text" name="jam_mulai"
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs"
                               placeholder="08:00">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Jam Selesai</label>
                        <input type="text" name="jam_selesai"
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs"
                               placeholder="10:00">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-[#6B7280] mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                              class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 outline-none text-xs"></textarea>
                </div>
                @if ($errors->has('global'))
                    <p class="text-xs text-red-600">{{ $errors->first('global') }}</p>
                @endif
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full bg-[#10B981] hover:bg-[#059669] text-white text-xs font-semibold shadow-md hover:shadow-lg transition-all">
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

            function boxes() {
                return Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]'));
            }

            function checkedBoxes() {
                return Array.prototype.slice.call(document.querySelectorAll('input[name="ids[]"]:checked'));
            }

            function syncSelectAll() {
                if (!selectAll) return;
                var all = boxes();
                var checked = checkedBoxes();
                selectAll.checked = all.length > 0 && checked.length === all.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    var all = boxes();
                    for (var i = 0; i < all.length; i++) {
                        all[i].checked = selectAll.checked;
                    }
                    syncSelectAll();
                });
            }

            document.addEventListener('change', function (e) {
                if (e.target && e.target.classList && e.target.classList.contains('jadwalRowCheckbox')) {
                    syncSelectAll();
                }
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
