<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
*/

/*
 * Auto-confirm delivered orders that customers forgot to confirm.
 * Industry standard: Shopee/Lazada = 7 days, Amazon = 14 days.
 * Runs at 02:00 daily so wallets are credited before business hours.
 */
Schedule::command('orders:auto-confirm --days=7')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/scheduler-auto-confirm.log'));
