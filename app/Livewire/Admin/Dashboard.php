<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\TBooking;
use App\Models\Notification;
use Carbon\Carbon;

#[Layout('components.layouts.app-admin')]
class Dashboard extends Component
{
    public function render()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalBookings = TBooking::count();
        $depositPaid = TBooking::where('is_deposit_paid', true)->count();
        $depositUnpaid = TBooking::where('is_deposit_paid', false)->count();

        $today = Carbon::today();
        $upcomingBookings = TBooking::whereHas('scheduleDateBook', function ($q) use ($today) {
            $q->whereDate('date_schedule', '>=', $today);
        })->count();

        $recentBookings = TBooking::with(['client', 'scheduleDateBook', 'scheduleTimeBook'])
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $unreadNotifications = Notification::where('is_read', false)->count();

        return view('livewire.admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalBookings',
            'depositPaid',
            'depositUnpaid',
            'upcomingBookings',
            'recentBookings',
            'unreadNotifications'
        ));
    }
}
