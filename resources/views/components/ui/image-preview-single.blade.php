@props([
    'src' => null, // string URL/base64
    'title' => 'Image Ready',
    'subtitle' => null,
    'thumbSize' => 'w-16 h-16',
])

@if($src)
    <div class="p-4 bg-green-50 border border-green-200 rounded-lg" x-data="{ open:false }">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-medium text-green-800">{{ $title }}</h4>
                @if($subtitle)
                    <p class="text-sm text-green-700">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="flex-shrink-0">
                <button type="button" @click="open=true" class="rounded overflow-hidden border border-green-200">
                    <img src="{{ $src }}" alt="Preview" class="object-cover {{ $thumbSize }}">
                </button>
            </div>
        </div>

        <!-- Modal preview -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/70" @click.self="open=false">
            <div class="bg-white rounded-xl shadow-2xl p-4 max-w-3xl w-full mx-4">
                <div class="flex items-center justify-between mb-3">
                    <h5 class="text-sm font-medium text-gray-900">Preview</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700" @click="open=false">✕</button>
                </div>
                <div class="max-h-[70vh] overflow-auto">
                    <img src="{{ $src }}" alt="Large preview" class="w-full h-auto rounded" />
                </div>
            </div>
        </div>
    </div>
@endif


