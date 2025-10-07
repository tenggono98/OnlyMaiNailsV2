@props([
    'files' => [], // array of TemporaryUploadedFile or ['src'=>...]
    'title' => 'Images Selected',
    'clearEvent' => null, // e.g., $set('variantNewImages', [])
])

@if(!empty($files))
    <div class="p-4 bg-green-50 border border-green-200 rounded-lg" x-data="{ open:false, src:null }">
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-sm font-medium text-green-800">{{ $title }} ({{ is_countable($files) ? count($files) : 0 }})</h4>
            @if($clearEvent)
                <button type="button" wire:click="{{ $clearEvent }}" class="text-xs text-red-600 hover:text-red-800">Clear</button>
            @endif
        </div>
        <div class="grid grid-cols-3 gap-2">
            @foreach($files as $idx => $file)
                @php $src = is_string($file) ? $file : (method_exists($file, 'temporaryUrl') ? $file->temporaryUrl() : (is_array($file) && isset($file['preview']) ? $file['preview'] : null)); @endphp
                @if($src)
                    <button type="button" class="relative border rounded-lg overflow-hidden" wire:key="multi-preview-{{ $idx }}" @click="open=true; src='{{ $src }}'">
                        <img src="{{ $src }}" alt="Selected preview" class="w-full h-20 object-cover">
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Modal preview -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/70" @click.self="open=false">
            <div class="bg-white rounded-xl shadow-2xl p-4 max-w-3xl w-full mx-4">
                <div class="flex items-center justify-between mb-3">
                    <h5 class="text-sm font-medium text-gray-900">Preview</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700" @click="open=false">✕</button>
                </div>
                <div class="max-h-[70vh] overflow-auto">
                    <img :src="src" alt="Large preview" class="w-full h-auto rounded" />
                </div>
            </div>
        </div>
    </div>
@endif


