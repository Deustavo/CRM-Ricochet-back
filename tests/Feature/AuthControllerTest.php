<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('register'), $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Usuario criado com sucesso']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testLoginUser()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'token_type', 'email', 'name', 'id']);
    }

    public function testLogoutUser()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
             ->postJson(route('logout'))
             ->assertStatus(200)
             ->assertJson(['message' => 'Token deletado com sucesso']);
    }
} 