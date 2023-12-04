<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログインできることを確認するテスト
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create([
            'name' => 'example',
            'email' => 'example@example.com',
            'password' => Hash::make(11111111),
        ]);

        $data = [
            'email' => $user->email,
            'password' => '11111111',
        ];

        // 実行
        $response = $this->postJson('/login', $data);

        // 検証
        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'ログインしました']);

        $this->assertAuthenticatedAs($user);
    }
}
