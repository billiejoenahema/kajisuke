<?php

namespace Tests\Feature\Archive;

use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事の履歴を登録できるか
     *
     * @return void
     */
    public function test_postArchive()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $housework = Housework::factory()->create();

        // 実行
        $response = $this->actingAs($user)->postJson('/api/archives', [
            'housework_id' => $housework->id,
            'date' => now(),
            'content' => 'テストコンテント',
        ]);
        $response
        ->assertCreated();

        $this->assertDatabaseCount('archives', 1);
    }
}
