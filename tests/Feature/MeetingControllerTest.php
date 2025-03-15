<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Meeting;
use Laravel\Sanctum\Sanctum;

class MeetingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexMeetings()
    {
        $user = User::factory()->create();
        Meeting::factory()->count(3)->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('meetings.index'));

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function testStoreMeeting()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'title' => 'New Meeting',
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'meeting_link' => 'http://example.com/meeting',
            'attendees' => [],
        ];

        $response = $this->postJson(route('meetings.store'), $data);

        $response->assertStatus(201)
                 ->assertJson(['title' => 'New Meeting']);

        $this->assertDatabaseHas('meetings', ['title' => 'New Meeting']);
    }

    public function testShowMeeting()
    {
        $user = User::factory()->create();
        $meeting = Meeting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('meetings.show', $meeting->id));

        $response->assertStatus(200)
                 ->assertJson(['id' => $meeting->id]);
    }

    public function testUpdateMeeting()
    {
        $user = User::factory()->create();
        $meeting = Meeting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $data = ['title' => 'Updated Meeting'];

        $response = $this->putJson(route('meetings.update', $meeting->id), $data);

        $response->assertStatus(200)
                 ->assertJson(['title' => 'Updated Meeting']);

        $this->assertDatabaseHas('meetings', ['id' => $meeting->id, 'title' => 'Updated Meeting']);
    }

    public function testDeleteMeeting()
    {
        $user = User::factory()->create();
        $meeting = Meeting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('meetings.destroy', $meeting->id));

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Meeting deleted successfully']);

        $this->assertDatabaseMissing('meetings', ['id' => $meeting->id]);
    }
} 