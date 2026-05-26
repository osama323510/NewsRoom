<?php

use App\Jobs\CacheMostUsedTagsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendWeeklyArticlesReport;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(new SendWeeklyArticlesReport)->weeklyOn(0, '00:00');
Schedule::job(new CacheMostUsedTagsJob)->hourly();
Schedule::command('articles:archive')->monthly();
Schedule::command('articles:report')->weeklyOn(5, '08:00');