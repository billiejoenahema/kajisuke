<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィールを取得できることを確認する。
     *
     * @return void
     */
    public function test_getProfile()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);

        // 実行
        $response = $this->actingAs($user)->getJson('/api/profiles');
        $response->assertStatus(Response::HTTP_OK);
    }
}
