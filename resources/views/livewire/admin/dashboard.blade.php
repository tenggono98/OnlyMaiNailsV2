<div>
    {{-- The best athlete wants his opponent at his best. --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
        <!-- Profit Card -->
        <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6">
            <div class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700">
                <dl>
                    <dt class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400">Profit</dt>
                    <dd class="text-3xl font-bold leading-none text-gray-900 dark:text-white">${{ number_format($totalProfit) }}</dd>
                </dl>
                <div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                        <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                        </svg>
                        Profit rate {{ $profitRate }}%
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 py-3">
                <dl>
                    <dt class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400">Income</dt>
                    <dd class="text-xl font-bold leading-none text-green-500 dark:text-green-400">${{ number_format($totalRevenue) }}</dd>
                </dl>
                <dl>
                    <dt class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400">Expense</dt>
                    <dd class="text-xl font-bold leading-none text-red-600 dark:text-red-500">-${{ number_format($totalExpenses) }}</dd>
                </dl>
            </div>

            <div id="bar-chart"></div>
            <div class="grid items-center justify-between grid-cols-1 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between pt-5">
                    <!-- Period Dropdown Button -->
                    <button
                        id="dropdownDefaultButton"
                        data-dropdown-toggle="lastDaysdropdown"
                        data-dropdown-placement="bottom"
                        class="inline-flex items-center text-sm font-medium text-center text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                        type="button">
                        @if($period == 'yesterday') Yesterday
                        @elseif($period == 'today') Today
                        @elseif($period == 'last_7_days') Last 7 days
                        @elseif($period == 'last_30_days') Last 30 days
                        @elseif($period == 'last_90_days') Last 90 days
                        @elseif($period == 'last_6_months') Last 6 months
                        @elseif($period == 'last_year') Last year
                        @else Last 6 months
                        @endif
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('yesterday')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('today')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('last_7_days')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('last_30_days')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('last_90_days')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('last_6_months')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 6 months</a>
                            </li>
                            <li>
                                <a href="#" wire:click.prevent="setPeriod('last_year')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last year</a>
                            </li>
                        </ul>
                    </div>
                    <a
                        href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-semibold text-blue-600 uppercase rounded-lg hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                        Revenue Report
                        <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Booking Stats Cards -->
        <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Bookings</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-blue-900 dark:text-blue-300">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                    </svg>
                    {{ ucfirst(str_replace('_', ' ', $period)) }}
                </span>
            </div>
            <dl class="grid grid-cols-2 gap-3 mb-4">
                <div class="p-3 bg-blue-50 rounded-lg dark:bg-gray-700">
                    <dt class="text-base font-normal text-blue-500 dark:text-blue-400">Total</dt>
                    <dd class="text-2xl font-bold text-blue-600 dark:text-blue-500">{{ $bookingStats['total'] }}</dd>
                </div>
                <div class="p-3 bg-green-50 rounded-lg dark:bg-gray-700">
                    <dt class="text-base font-normal text-green-500 dark:text-green-400">Completed</dt>
                    <dd class="text-2xl font-bold text-green-600 dark:text-green-500">{{ $bookingStats['completed'] }}</dd>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg dark:bg-gray-700">
                    <dt class="text-base font-normal text-yellow-500 dark:text-yellow-400">Pending</dt>
                    <dd class="text-2xl font-bold text-yellow-600 dark:text-yellow-500">{{ $bookingStats['pending'] }}</dd>
                </div>
                <div class="p-3 bg-red-50 rounded-lg dark:bg-gray-700">
                    <dt class="text-base font-normal text-red-500 dark:text-red-400">Cancelled</dt>
                    <dd class="text-2xl font-bold text-red-600 dark:text-red-500">{{ $bookingStats['cancelled'] }}</dd>
                </div>
            </dl>
        </div>

        <!-- Client Info Card -->
        <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6 col-span-1 xl:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Client Base</h3>
                <span class="bg-purple-100 text-purple-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-purple-900 dark:text-purple-300">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4H1m3 4H1m3 4H1m3 4H1m6.071.286a3.429 3.429 0 1 1 6.858 0M4 1h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                    </svg>
                    Total Clients
                </span>
            </div>
            <div class="flex items-center justify-center h-32">
                <div class="text-center">
                    <h4 class="text-7xl font-bold text-gray-900 dark:text-white">{{ $clientCount }}</h4>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Registered clients</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue & Expense Chart -->
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6 mb-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Revenue vs. Expenses</h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-blue-900 dark:text-blue-300">
                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                </svg>
                {{ ucfirst(str_replace('_', ' ', $period)) }}
            </span>
        </div>
        <div id="revenue-chart" class="h-72"></div>
    </div>

    <!-- ApexCharts Script -->
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Get monthly data from Livewire component
            const monthlyData = @json($monthlyData);

            // Create chart options
            const options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Revenue',
                        data: monthlyData?.revenue || [],
                        color: '#0ea5e9'
                    },
                    {
                        name: 'Expenses',
                        data: monthlyData?.expenses || [],
                        color: '#f87171'
                    }
                ],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: monthlyData?.labels || [],
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            };

            // Create the chart
            const chart = new ApexCharts(
                document.querySelector("#revenue-chart"),
                options
            );
            chart.render();

            // Listen for period changes and update chart
            Livewire.on('updateChart', (data) => {
                if (data) {
                    chart.updateOptions({
                        xaxis: {
                            categories: data.labels || []
                        }
                    });
                    chart.updateSeries([
                        {
                            name: 'Revenue',
                            data: data.revenue || []
                        },
                        {
                            name: 'Expenses',
                            data: data.expenses || []
                        }
                    ]);
                }
            });

            // Update the chart when Livewire properties change - fixed for Livewire 3.x
            Livewire.hook('commit', ({ component, commit }) => {
                if (commit?.response?.effects?.payload?.effects?.updates) {
                    const updates = commit.response.effects.payload.effects.updates;
                    const monthlyDataUpdate = updates.find(update => update.name === 'monthlyData');

                    if (monthlyDataUpdate && monthlyDataUpdate.value) {
                        const updatedData = monthlyDataUpdate.value;

                        chart.updateOptions({
                            xaxis: {
                                categories: updatedData.labels || []
                            }
                        });
                        chart.updateSeries([
                            {
                                name: 'Revenue',
                                data: updatedData.revenue || []
                            },
                            {
                                name: 'Expenses',
                                data: updatedData.expenses || []
                            }
                        ]);
                    }
                }
            });
        });
    </script>
    @endpush
</div>
