<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meeting;
use App\Events\MeetingReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendMeetingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meetings:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for meetings starting in 5 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $start = $now->format('Y-m-d\TH:i');
        $reminderTime = $now->copy()->addMinutes(5)->format('Y-m-d\TH:i');

        $meetings = Meeting::whereBetween('start_time', [$start, $reminderTime])->get();

        foreach ($meetings as $meeting) {
            event(new MeetingReminder($meeting));
        }

        return 0;
    }
} 