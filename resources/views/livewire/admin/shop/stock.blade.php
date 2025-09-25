<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Stock" />

  <div class="grid grid-cols-1 gap-8 mt-6 xl:grid-cols-3">
    <!-- Adjust Stock Card -->
    <div class="xl:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Adjust Stock</h3>
        <p class="text-sm text-gray-600 mt-1">Increase or decrease product inventory</p>
      </div>
      <form wire:submit.prevent="adjust" class="p-6 space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
          <select wire:model.live="product_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select product</option>
            @foreach($products as $p)
              <option value="{{ $p->id }}">{{ $p->name_service }} (Stock: {{ $p->stock }})</option>
            @endforeach
          </select>
          @error('product_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        @if(!empty($variants))
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Variant (optional)</label>
          <select wire:model="variant_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select variant</option>
            @foreach($variants as $v)
              <option value="{{ $v->id }}">{{ $v->name }} (SKU: {{ $v->sku }}) — Stock: {{ $v->stock }}</option>
            @endforeach
          </select>
        </div>
        @endif

        @if($selectedVariant)
          <div class="rounded-lg bg-gray-50 border border-gray-200 p-3 text-sm">
            <div class="flex items-center justify-between">
              <div>
                <div class="font-medium text-gray-900">Selected Variant</div>
                <div class="text-gray-600">{{ $selectedVariant->name }} ({{ $selectedVariant->sku }})</div>
              </div>
              <div class="text-right">
                <div class="text-xs text-gray-500">Current Stock</div>
                <div class="text-lg font-semibold">{{ $selectedVariant->stock }}</div>
              </div>
            </div>
          </div>
        @endif
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Delta</label>
            <input type="number" wire:model="delta"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="e.g. 10 or -5" />
            @error('delta') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
            <input type="text" wire:model="reason"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>
        </div>
        <div>
          <button x-bind:disabled="!$wire.product_id || !$wire.variant_id || !$wire.delta"
                  class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
            Adjust Stock
          </button>
        </div>
      </form>
    </div>

    <!-- Recent Adjustments Card -->
    <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Recent Adjustments</h3>
      </div>
      <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variant</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delta</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          @forelse($adjustments as $a)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-3 text-sm text-gray-900">{{ $a->created_at }}</td>
              <td class="px-6 py-3 text-sm text-gray-900">
                @if($a->variant)
                  <div class="font-medium">{{ $a->variant->name }}</div>
                  <div class="text-xs text-gray-500">SKU: {{ $a->variant->sku }}</div>
                @else
                  <span class="text-gray-500">—</span>
                @endif
              </td>
              <td class="px-6 py-3 text-sm text-gray-900">{{ $a->delta }}</td>
              <td class="px-6 py-3 text-sm text-gray-700">{{ $a->reason }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-8 text-center">
                <p class="text-sm text-gray-500">No adjustments yet</p>
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

