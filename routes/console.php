<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\sendInterestedCourseCategoryEmailCron;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command("app:send-interested-course-category-email-cron")->monthly();

// Newsletter: send to all active subscribers on the 1st of every month at 9:00 (Asia/Kuala_Lumpur). Content based on current month.
Schedule::command('newsletter:send-monthly')->monthlyOn(1, '9:00')->timezone('Asia/Kuala_Lumpur');
