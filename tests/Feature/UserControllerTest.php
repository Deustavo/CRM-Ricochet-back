<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Updated Name'];

        // Authenticate the user
        Sanctum::actingAs($user);

        $response = $this->putJson(route('user.update', $user->id), $data);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User updated successfully']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        // Authenticate the user
        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('user.delete', $user->id));

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User deleted successfully']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testGetAllUsers()
    {
        $users = User::factory()->count(3)->create();

        // Authenticate the user
        Sanctum::actingAs($users->first());

        $response = $this->getJson(route('user.getAll'));

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'users');
    }
} 