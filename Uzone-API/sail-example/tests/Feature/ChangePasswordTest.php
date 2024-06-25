<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testChangePassword()
    {
        $user = User::factory()->create(['password' => Hash::make('old_password')]);

        $data = [
            'email' => $user->email,
            'current_password' => 'old_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ];

        $response = $this->actingAs($user)->putJson('/change-password', $data);

        $response->assertStatus(200);
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }
}
