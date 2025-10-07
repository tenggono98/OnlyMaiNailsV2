<div class="p-4 space-y-6">
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Total Users</div>
      <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</div>
    </div>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Total Admins</div>
      <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalAdmins }}</div>
    </div>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Total Bookings</div>
      <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalBookings }}</div>
    </div>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Unread Notifications</div>
      <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $unreadNotifications }}</div>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Deposit Paid</div>
      <div class="mt-1 text-2xl font-semibold text-green-600">{{ $depositPaid }}</div>
    </div>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Deposit Unpaid</div>
      <div class="mt-1 text-2xl font-semibold text-red-600">{{ $depositUnpaid }}</div>
    </div>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
      <div class="text-sm text-gray-500 dark:text-gray-400">Upcoming Bookings</div>
      <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $upcomingBookings }}</div>
    </div>
  </div>

  <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h3>
      <a href="{{ route('admin.booking') }}" class="text-sm font-medium text-blue-600 hover:underline">View all</a>
    </div>
    <div class="mt-4">
      <x-ui.admin-table title="Recent Bookings" :subtitle="count($recentBookings).' record'.(count($recentBookings)!==1?'s':'')">
        <x-slot name="head">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deposit</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          </tr>
        </x-slot>
        @forelse ($recentBookings as $b)
          <tr>
            <td class="px-4 py-3 font-medium text-gray-900">{{ $b->code_booking }}</td>
            <td class="px-4 py-3">{{ $b->client->name ?? '-' }}</td>
            <td class="px-4 py-3">{{ optional($b->scheduleDateBook)->date_schedule }}</td>
            <td class="px-4 py-3">{{ optional($b->scheduleTimeBook)->time }}</td>
            <td class="px-4 py-3">{{ $b->is_deposit_paid ? 'Paid' : 'Unpaid' }}</td>
            <td class="px-4 py-3">{{ $b->status ?? 'active' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-4 py-6 text-center">No recent bookings</td>
          </tr>
        @endforelse
      </x-ui.admin-table>
    </div>
  </div>
</div>
