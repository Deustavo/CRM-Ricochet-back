<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meeting;
use App\Events\MeetingReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
     * get the attendees for the meeting
     * 
     * @param Meeting $meeting
     * @return Array
     */
    protected function getAttendees($meeting)
    {
        $attendees = DB::table('meeting_user')
            ->join('users', 'meeting_user.user_id', '=', 'users.id')
            ->where('meeting_user.meeting_id', $meeting->id)
            ->select('users.id')
            ->get()
            ->pluck('id');

        return $attendees;
    }

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
        $attendees = [];

        foreach ($meetings as $meeting) {
            $attendees = $this->getAttendees($meeting);
            $meetingData = [
                'id' => $meeting->id,
                'title' => $meeting->title,
                'start_time' => $meeting->start_time,
                'attendees' => $attendees
            ];
            event(new MeetingReminder($meetingData));
        }

        return 0;
    }
} 