<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser()
    {
        $data = [
            'kanji_last_name' =>'岩田',
            'kanji_first_name' =>'祐璃',
            'hiragana_last_name' =>'いわた',
            'hiragana_first_name' => 'ゆうり',
            'roman_last_name' =>'Iwata',
            'roman_first_name' =>'Yuri',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
