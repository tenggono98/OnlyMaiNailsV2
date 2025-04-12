<div>
    <div class="px-4">
        <x-pages.admin.title-header-admin title="Booking Reports" />

        <!-- Filter Panel -->
        <div class="p-4 mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex flex-col mb-4 md:flex-row md:items-end md:justify-between">
                <h3 class="text-lg font-medium">Filters</h3>

                <div class="mt-3 space-x-2 md:mt-0">
                    <input type="text" wire:model="exportName"
                           class="px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Export filename">
                    <button wire:click="exportToExcel"
                            class="px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Export to Excel
                    </button>

                    <button wire:click="resetFilters"
                            class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset Filters
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Date Range -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Date Range</label>
                    <div class="flex items-center space-x-2">
                        <input type="date" wire:model.live="startDate"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <span>to</span>
                        <input type="date" wire:model.live="endDate"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Booking Status</label>
                    <select wire:model.live="statusFilter"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="1">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancel">Cancelled</option>
                        <option value="reschedule">Rescheduled</option>
                    </select>
                </div>

                <!-- Customer Filter -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Customer</label>
                    <select wire:model.live="customerFilter"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Deposit Status Filter -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Deposit Status</label>
                    <select wire:model.live="depositFilter"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Bookings -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Bookings</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $summaryStats['totalBookings'] }}</dd>
            </div>

            <!-- Total Revenue -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($summaryStats['totalRevenue'], 2) }}</dd>
            </div>

            <!-- Total Deposits -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Deposits Collected</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($summaryStats['totalDeposits'], 2) }}</dd>
            </div>

            <!-- Pending Deposits -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Pending Deposits</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($summaryStats['pendingDeposits'], 2) }}</dd>
            </div>
        </div>

        <!-- More Stats Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
            <!-- Completed Bookings -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Completed Bookings</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-600">{{ $summaryStats['completedBookings'] }}</dd>
            </div>

            <!-- Pending Bookings -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Pending Bookings</dt>
                <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ $summaryStats['pendingBookings'] }}</dd>
            </div>

            <!-- Cancelled Bookings -->
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <dt class="text-sm font-medium text-gray-500 truncate">Cancelled Bookings</dt>
                <dd class="mt-1 text-3xl font-semibold text-red-600">{{ $summaryStats['cancelledBookings'] }}</dd>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Booking ID</th>
                        <th scope="col" class="px-6 py-3">Customer</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Time</th>
                        <th scope="col" class="px-6 py-3">Services</th>
                        <th scope="col" class="px-6 py-3">People</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Deposit</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $booking->code_booking }}
                            </th>
                            <td class="px-6 py-4">{{ $booking->client->name }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->scheduleDateBook->date_schedule)->format('M d, Y') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->scheduleTimeBook->time)->format('h:i A') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    @foreach($booking->detailService as $service)
                                        <span class="mb-1 text-xs">{{ $service->name_service }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $booking->qty_people_booking }}</td>
                            <td class="px-6 py-4">${{ number_format($booking->total_price_booking, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($booking->is_deposit_paid)
                                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Paid</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->status === 'completed')
                                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Completed</span>
                                @elseif($booking->status === '1')
                                    <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                @elseif($booking->status === 'cancel')
                                    <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Cancelled</span>
                                @elseif($booking->status === 'reschedule')
                                    <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Rescheduled</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">{{ $booking->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="9" class="px-6 py-4 text-center">No bookings found matching the criteria</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
