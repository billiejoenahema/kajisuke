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
     * 家事を登録できるかどうか
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
            'cycle_num' => '+1',
            'cycle_unit' => 'week',
        ]);
        $response
        ->assertCreated();

        $this->assertDatabaseCount('houseworks', 1);
    }
}
