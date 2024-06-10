@props([
    'id' => 'id-modal',
    'type' => 'form'
])
<div class="flex items-center gap-2 p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
    <div class="flex-auto">
        @if($type == "form")
        <x-pages.btn value='Submit'  action='submit' data-modal-hide="{{ $id }}" />
        @endif
    </div>
    <div class="">
    <x-pages.btn value='Cancel' type='info'  data-modal-hide="{{ $id }}" />

    </div>

    </div>
