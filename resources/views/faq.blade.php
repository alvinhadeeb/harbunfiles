@extends('layouts.app')

@section('title', 'FAQ - Harapan Bunda')

@section('content')
<!-- Title Section -->
<div class="bg-white pt-10 pb-6">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Pertanyaan yang Sering Diajukan</h1>
        <p class="text-gray-500 mt-3 text-lg">Temukan jawaban atas pertanyaan umum seputar Yayasan Harapan Bunda</p>
    </div>
</div>

<!-- FAQ Content -->
<div class="bg-white pb-20">
    <div class="max-w-3xl mx-auto px-4">
        @if($faqList->count() > 0)
            <div class="space-y-4">
                @foreach($faqList as $index => $faq)
                    <div class="border border-gray-200 rounded-xl overflow-hidden faq-item">
                        <button type="button" onclick="toggleFaq({{ $index }})" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition" id="faq-btn-{{ $index }}">
                            <span class="font-semibold text-gray-800 pr-4">{{ $faq->pertanyaan }}</span>
                            <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" id="faq-icon-{{ $index }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="hidden px-6 pb-5" id="faq-answer-{{ $index }}">
                            <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $faq->jawaban }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500">Belum ada FAQ</p>
            </div>
        @endif

        <!-- Contact CTA -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Masih ada pertanyaan?</h3>
            <p class="text-gray-600 mb-4">Jangan ragu untuk menghubungi kami</p>
            <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</div>

<script>
    function toggleFaq(index) {
        var answer = document.getElementById('faq-answer-' + index);
        var icon = document.getElementById('faq-icon-' + index);
        
        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            answer.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection
