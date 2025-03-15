<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Meeting;
use App\Models\User;
use App\Events\MeetingCreated;
use Illuminate\Support\Facades\Event;

class MeetingCreatedEventTest extends TestCase
{
    use RefreshDatabase;

    public function testMeetingCreatedEventIsDispatched()
    {
        Event::fake();

        $user = User::factory()->create();
        $meeting = Meeting::factory()->create(['user_id' => $user->id]);

        // Dispatch the event
        event(new MeetingCreated($meeting));

        // Assert that the event was dispatched
        Event::assertDispatched(MeetingCreated::class, function ($event) use ($meeting) {
            return $event->meeting->id === $meeting->id;
        });
    }
} 