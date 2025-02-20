<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MailTester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-tester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        \Mail::raw('This is a test email', function ($message) {
            $message->to('tenggono@gmail.com')->subject('Test Email');
        });

        dd('test');
    }
}
