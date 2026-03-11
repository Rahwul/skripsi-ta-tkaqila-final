@extends('layouts.admin')

@section('title', 'Konten Website | TK Aqila')
@section('page_title', 'Konten Website')
@section('page_subtitle', 'Kelola isi konten landing page')

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
        <div class="p-4 sm:p-5 border-b border-gray-100">
            <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Pengaturan Konten</h2>
            <p class="text-xs text-[#6B7280] mt-1">Perubahan tersimpan di server API dan tampil di landing page.</p>
        </div>

        <form action="{{ route('admin.konten.update') }}" method="POST" class="p-4 sm:p-5 space-y-4">
            @csrf

            @foreach ($fields as $f)
                @php
                    $key = $f['key'];
                    $value = $content[$key] ?? '';
                    $isLong = str_contains($key, 'description') || str_contains($key, 'feature');
                @endphp

                <div>
                    <label class="block text-[11px] font-medium text-[#6B7280] mb-1">{{ $f['label'] }}</label>
                    <div class="text-[11px] text-[#9CA3AF] mb-2">{{ $key }}</div>
                    @if ($isLong)
                        <textarea name="content[{{ $key }}]" rows="3"
                                  class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-xs outline-none">{{ $value }}</textarea>
                    @else
                        <input type="text" name="content[{{ $key }}]" value="{{ $value }}"
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-xs outline-none">
                    @endif
                </div>
            @endforeach

            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-[#4F46E5] hover:bg-[#4338CA] text-white text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

