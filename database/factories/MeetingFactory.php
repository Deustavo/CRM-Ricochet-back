<?php

namespace Database\Factories;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Assumes a user factory exists
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_time' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'meeting_link' => $this->faker->url,
        ];
    }
} 