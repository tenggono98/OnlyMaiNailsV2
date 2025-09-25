<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Orders" />

  <div class="grid grid-cols-1 gap-8 mt-6 xl:grid-cols-3">
    <!-- Order Form Card -->
    <div class="xl:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">{{ $is_edit ? 'Edit Order' : 'Create Order' }}</h3>
        <p class="text-sm text-gray-600 mt-1">Manage order details and add items</p>
      </div>
      <form wire:submit.prevent="save" class="p-6 space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">User ID</label>
          <input type="number" wire:model.defer="user_id"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          @error('user_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select wire:model.defer="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="pending">pending</option>
            <option value="paid">paid</option>
            <option value="shipped">shipped</option>
            <option value="completed">completed</option>
            <option value="cancelled">cancelled</option>
          </select>
          @error('status') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Select Product</label>
          <select wire:model.live="selected_product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select product</option>
            @foreach($products as $p)
              <option value="{{ $p->id }}">{{ $p->name_service }}</option>
            @endforeach
          </select>
        </div>

        @if(!empty($variants))
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Select Variant</label>
          <select wire:change="addItem($event.target.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select variant</option>
            @foreach($variants as $v)
              <option value="{{ $v->id }}">{{ $v->name }} (SKU: {{ $v->sku }}) - ${{ number_format($v->price,2) }} - Stock: {{ $v->stock }}</option>
            @endforeach
          </select>
        </div>
        @endif
        <div>
          <table class="w-full text-sm">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                <th class="px-3 py-2"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach($items as $i => $item)
              <tr>
                <td class="px-3 py-2">
                  {{ $item['name'] }}
                  @if(!empty($item['variant_name']))
                    - {{ $item['variant_name'] }}
                  @endif
                  @if(!empty($item['variant_sku']))
                    <span class="text-gray-500 text-xs">(SKU: {{ $item['variant_sku'] }})</span>
                  @endif
                </td>
                <td class="px-3 py-2">${{ number_format($item['price'],2) }}</td>
                <td class="px-3 py-2">
                  <input type="number" min="1" wire:input="updateQty({{ $i }}, $event.target.value)" value="{{ $item['qty'] }}" class="w-20 px-2 py-1 border border-gray-300 rounded"/>
                </td>
                <td class="px-3 py-2">${{ number_format($item['subtotal'],2) }}</td>
                <td class="px-3 py-2"><button type="button" wire:click="removeItem({{ $i }})" class="text-red-600 hover:underline">Remove</button></td>
              </tr>
              @endforeach
              @if(empty($items))
              <tr><td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500">No items</td></tr>
              @endif
            </tbody>
          </table>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
          <textarea wire:model.defer="notes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <div class="flex gap-2">
          <button class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Save Order</button>
          <button type="button" wire:click="resetForm" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Reset</button>
        </div>
      </form>
    </div>

    <!-- Orders List Card -->
    <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Orders</h3>
      </div>
      <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orders as $o)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $o->id }}</td>
                <td class="px-6 py-4">{{ $o->client->name ?? $o->user_id }}</td>
                <td class="px-6 py-4">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $o->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $o->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $o->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $o->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $o->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                  ">{{ ucfirst($o->status) }}</span>
                </td>
                <td class="px-6 py-4 font-medium">${{ number_format($o->total_price,2) }}</td>
                <td class="px-6 py-4">
                  @if($o->items)
                    <div class="text-xs text-gray-700 space-y-1">
                      @foreach($o->items as $it)
                        <div>- {{ $it->name }} @if($it->variant) <span class="text-gray-500">({{ $it->variant->name }})</span> @endif × {{ $it->qty }}</div>
                      @endforeach
                    </div>
                  @endif
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="inline-flex gap-2">
                    <button wire:click="edit({{ $o->id }})" class="px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200">Edit</button>
                    <button wire:click="delete({{ $o->id }})" class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200">Delete</button>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No orders</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

