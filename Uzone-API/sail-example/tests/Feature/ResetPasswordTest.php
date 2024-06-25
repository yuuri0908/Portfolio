<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPassword()
    {
        $user = User::factory()->create();
        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $data = [
            'email' => $user->email,
            'token' => $token,
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ];

        $response = $this->actingAs($user)->postJson('/reset-password', $data);

        $response->assertStatus(200);
        $user->refresh();
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }
}
