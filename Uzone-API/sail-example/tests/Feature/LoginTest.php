<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type']);
    }
}
