<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Mail\VerificationCodeMail;

class SendVerificationCodeTest extends TestCase
{
    use RefreshDatabase;

    public function testSendVerificationCodeWithoutEmail()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/send-verification-code', ['email' => null]);

        $response->assertStatus(422)
                 ->assertJson(['message' => 'メールアドレスが入力されていません']);
    }

    public function testSendVerificationCodeWithExistingEmail()
    {
        $email = 'test@example.com';
        $user = User::factory()->create([
            'email' => $email
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/send-verification-code', ['email' => $email]);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'このメールアドレスは既に登録されています']);
    }

    public function testSendVerificationCodeWithNewEmail()
    {
        Mail::fake();



        $email = 'newuser@example.com';

        $response = $this->postJson('/send-verification-code', ['email' => $email]);

        $response->assertStatus(200)
                 ->assertJson(['message' => '認証コードが送信されました']);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);

        // verification_codeが空でないことを確認
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user->verification_code);

        Mail::assertSent(VerificationCodeMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
