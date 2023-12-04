<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリを登録できることを確認するテスト
     *
     * @return void
     */
    public function test_postCategory()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        // 実行
        $response = $this->actingAs($user)->postJson('/api/categories', [
            'name' => 'テストカテゴリ{rand(1, 100)}',
        ]);
        $response->assertCreated();
        $this->assertDatabaseCount('categories', 1);
    }
}
