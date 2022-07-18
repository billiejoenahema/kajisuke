<?php

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事を登録できることを確認するテスト
     *
     * @return void
     */
    public function test_postHousework()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // 実行
        $response = $this->actingAs($user)->postJson('/api/houseworks', [
            'category_id' => $category->id,
            'title' => 'テストタイトル',
            'comment' => 'テストコメント',
            'cycle_num' => rand(1, 31),
            'cycle_unit' => rand(1, 4),
            'next_date' => now()->addWeek(),
        ]);
        $response
        ->assertCreated();

        $this->assertDatabaseCount('houseworks', 1);
    }
}
