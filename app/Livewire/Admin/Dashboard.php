<?php

namespace App\Livewire\Admin;

use App\Models\TBooking;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $period = 'last_6_months';
    public $bookingStats = [];
    public $totalRevenue = 0;
    public $totalExpenses = 0;
    public $totalProfit = 0;
    public $profitRate = 0;
    public $monthlyData = [];

    public function mount()
    {
        $this->updateStats();
    }

    public function setPeriod($period)
    {
        $this->period = $period;
        $this->updateStats();
    }

    public function updateStats()
    {
        // Define date range based on selected period
        $endDate = Carbon::now();
        $startDate = match($this->period) {
            'yesterday' => Carbon::yesterday(),
            'today' => Carbon::today(),
            'last_7_days' => Carbon::now()->subDays(7),
            'last_30_days' => Carbon::now()->subDays(30),
            'last_90_days' => Carbon::now()->subDays(90),
            'last_6_months' => Carbon::now()->subMonths(6),
            'last_year' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonths(6)
        };

        // Get booking statistics
        $this->bookingStats = [
            'total' => $this->getBookingCount($startDate, $endDate),
            'completed' => $this->getBookingCount($startDate, $endDate, 'completed'),
            'pending' => $this->getBookingCount($startDate, $endDate, '1'),
            'cancelled' => $this->getBookingCount($startDate, $endDate, 'cancel')
        ];

        // Calculate revenue
        $this->totalRevenue = $this->calculateRevenue($startDate, $endDate);

        // For demonstration, set expenses as a percentage of revenue (in a real app, would be from actual data)
        $this->totalExpenses = round($this->totalRevenue * 0.77);

        // Calculate profit
        $this->totalProfit = $this->totalRevenue - $this->totalExpenses;

        // Calculate profit rate
        $this->profitRate = $this->totalRevenue > 0 ? round(($this->totalProfit / $this->totalRevenue) * 100, 1) : 0;

        // Generate monthly data for chart
        $this->generateMonthlyData($startDate, $endDate);
    }

    private function getBookingCount($startDate, $endDate, $status = null)
    {
        $query = TBooking::whereBetween('created_at', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    private function calculateRevenue($startDate, $endDate)
    {
        return TBooking::whereBetween('created_at', [$startDate, $endDate])
            ->where(function($query) {
                $query->where('status', 'completed')
                      ->orWhere('status', '1');
            })
            ->sum('total_price_booking');
    }

    private function generateMonthlyData($startDate, $endDate)
    {
        $months = [];
        $revenue = [];
        $expenses = [];

        // If period is short (today/yesterday), show hourly data instead
        if ($this->period == 'today' || $this->period == 'yesterday') {
            // Implement hourly data if needed
            $this->monthlyData = [
                'labels' => ['8am', '10am', '12pm', '2pm', '4pm', '6pm', '8pm'],
                'revenue' => [1200, 1900, 3000, 1800, 2100, 2500, 1500],
                'expenses' => [800, 1200, 2000, 1500, 1700, 1900, 900]
            ];
            return;
        }

        // Otherwise, calculate monthly data
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $monthYear = $currentDate->format('M Y');
            $monthStart = clone $currentDate->startOfMonth();
            $monthEnd = clone $currentDate->endOfMonth();

            $months[] = $monthYear;
            $revenue[] = $this->calculateRevenue($monthStart, $monthEnd);
            $expenses[] = round($revenue[count($revenue) - 1] * 0.75); // Simplified expense calculation

            $currentDate->addMonth();
        }

        $this->monthlyData = [
            'labels' => $months,
            'revenue' => $revenue,
            'expenses' => $expenses
        ];
    }

    public function render()
    {
        // Also fetch recent client count
        $clientCount = User::where('role', 'user')->count();

        return view('livewire.admin.dashboard', [
            'clientCount' => $clientCount
        ])->layout('components.layouts.app-admin');
    }
}
