<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Invoices" />

  <div class="grid grid-cols-1 gap-8 mt-6 xl:grid-cols-3">
    <!-- Generate Invoice Card -->
    <div class="xl:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Generate Invoice</h3>
        <p class="text-sm text-gray-600 mt-1">Create invoice from an existing order</p>
      </div>
      <form wire:submit.prevent="createFromOrder" class="p-6 space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
          <select wire:model="order_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select order</option>
            @foreach($orders as $o)
              <option value="{{ $o->id }}">#{{ $o->id }} - ${{ number_format($o->total_price,2) }} ({{ $o->status }})</option>
            @endforeach
          </select>
          @error('order_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
          <button class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create Invoice</button>
        </div>
      </form>
    </div>

    <!-- Invoices List using Admin Table -->
    <div class="xl:col-span-2">
      <x-ui.admin-table title="Invoices" :subtitle="$invoices->count().' total'" search :paginator="$invoices">
        <x-slot name="head">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Items</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </x-slot>
        @forelse($invoices as $inv)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">{{ $inv->id }}</td>
            <td class="px-6 py-4">{{ $inv->invoice_number }}</td>
            <td class="px-6 py-4">#{{ $inv->t_order_id }}</td>
            <td class="px-6 py-4 font-medium">${{ number_format($inv->total,2) }}</td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ $inv->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($inv->status) }}
              </span>
            </td>
            <td class="px-6 py-4">
              @if($inv->order && $inv->order->items)
                <div class="text-xs text-gray-700 space-y-1">
                  @foreach($inv->order->items as $it)
                    <div>- {{ $it->name }} @if($it->variant) <span class="text-gray-500">({{ $it->variant->name }})</span> @endif × {{ $it->qty }}</div>
                  @endforeach
                </div>
              @endif
            </td>
            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
              <button wire:click="generatePdf({{ $inv->id }})" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-gray-100 rounded-lg hover:bg-gray-200">Generate</button>
              <a href="{{ route('admin.shop.invoice.download', $inv->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-gray-100 rounded-lg hover:bg-gray-200">Download</a>
              <button wire:click="emailInvoice({{ $inv->id }})" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-[#fadde1] rounded-lg hover:border hover:border-[#fadde1] hover:bg-transparent">Email</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">No invoices</td></tr>
        @endforelse
      </x-ui.admin-table>
    </div>
  </div>
</div>

