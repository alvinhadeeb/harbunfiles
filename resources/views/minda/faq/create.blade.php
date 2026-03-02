@extends('minda.layout')

@section('title', 'Tambah FAQ')
@section('page-title', 'Tambah FAQ')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('minda.faq.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                <input type="text" name="pertanyaan" value="{{ old('pertanyaan') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('pertanyaan') border-red-500 @enderror"
                    placeholder="Tulis pertanyaan FAQ">
                @error('pertanyaan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Jawaban <span class="text-red-500">*</span></label>
                <textarea name="jawaban" rows="6" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('jawaban') border-red-500 @enderror"
                    placeholder="Tulis jawaban FAQ">{{ old('jawaban') }}</textarea>
                @error('jawaban')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <p class="text-xs text-gray-400 mt-1">Angka kecil tampil duluan</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <label class="flex items-center gap-3 mt-3 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700">Tampilkan di halaman FAQ</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    Simpan FAQ
                </button>
                <a href="{{ route('minda.faq.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
