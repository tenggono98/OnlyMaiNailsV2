<?php

use Carbon\Carbon;
use App\Models\TBooking;
use App\Models\Notification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckAndCancelUnpaidBookings;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('bookings:check-unpaid', function () {
    $now = Carbon::now();
        $deadline = $now->subHours(2); // Calculate the time threshold

        // Fetch bookings that were created more than 2 hours ago and are unpaid
        $unpaidBookings = TBooking::where('is_deposit_paid', '=','0')
            ->where('created_at', '<=', $deadline)
            ->get();

        foreach ($unpaidBookings as $booking) {
            // Cancel the booking
            $booking->status = 'cancel'; // Assuming you have a status column
            $booking->save();

            // Optionally, send notification to the user
             // Send Notification
             $notif = new Notification;
             $notif->title_notification = 'Your Booking Has Been Canceled';
             $notif->description_notification = 'Your booking with code ' . $booking->code_booking . ' has been canceled because the deposit payment deadline was not met.';$notif->referance_id = $booking->uuid;
             $notif->for_role_notification = 'user';
             $notif->notif_for = $booking->client->id;
             $notif->save();

            $this->info('Booking ID ' . $booking->id . ' has been canceled.');
        }
})->purpose('Check and cancel the booking within 2H if customer not paid the deposit')->everyTwoHours();

// Artisan::command('check-unpaid')->everyTwoHours();



