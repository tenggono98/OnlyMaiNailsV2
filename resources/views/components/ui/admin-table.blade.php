@props([
    'title' => null,
    'subtitle' => null,
    'count' => null,
    'search' => false,
    'actions' => null, // view string or slot
    'paginator' => null, // LengthAwarePaginator|Paginator|null
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-200']) }}>
  <div class="px-6 py-4 border-b border-gray-200">
    <div class="flex items-center justify-between">
      <div>
        @if($title)
          <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        @endif
        @if($subtitle)
          <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
        @endif
      </div>
      <div class="flex items-center space-x-3">
        @if($search)
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <input type="text" placeholder="Search..."
                   class="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>
        @endif
        @if($actions)
          {!! $actions !!}
        @elseif (isset($actionsSlot))
          {{ $actionsSlot }}
        @endif
      </div>
    </div>
  </div>

  <div class="overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full table-fixed md:table-auto divide-y divide-gray-200">
        <thead class="bg-gray-50">
          {{ $head ?? '' }}
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          {{ $slot }}
        </tbody>
      </table>
    </div>
    @if($paginator && is_object($paginator) && method_exists($paginator, 'links'))
      <div class="px-6 py-4 border-t border-gray-200 bg-white">
        {!! $paginator->links() !!}
      </div>
    @elseif (isset($footer))
      <div class="px-6 py-4 border-t border-gray-200 bg-white">
        {{ $footer }}
      </div>
    @endif
  </div>
</div>

{{-- Usage:
<x-ui.admin-table title="Products" :subtitle="$count.' items'" search>
  <x-slot name="head">
    <tr>...</tr>
  </x-slot>
  <tr>...</tr>
</x-ui.admin-table>
--}}


