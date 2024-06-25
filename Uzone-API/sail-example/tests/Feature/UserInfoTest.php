<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function testUserInfo()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/user-info');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $user->id,
            'email' => $user->email,
            'kanji_last_name'=>$user->kanji_last_name,
            'kanji_first_name'=>$user->kanji_first_name,
        ]);
    }
}
