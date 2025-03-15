<?php

use Illuminate\Console\Scheduling\Schedule;

app()->resolving(Schedule::class, function (Schedule $schedule) {
    $schedule->command('meetings:send-reminders')->everyMinute();
});