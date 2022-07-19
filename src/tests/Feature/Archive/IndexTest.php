<?php

namespace Tests\Feature\Archive;

use App\Models\Archive;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事履歴一覧を取得できることを確認するテスト
     *
     * @return void
     */
    public function test_indexArchive()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $housework = Housework::factory()->create([
            'user_id' => $user->id,
        ]);
        Archive::factory()->count(10)->create([
            'housework_id' => $housework->id,
        ]);

        // 実行
        $response = $this->actingAs($user)->getJson('/api/archives');
        $response->assertOK();
        $response->assertJsonCount(10);
    }
}
