<?php

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事一覧を取得できることを確認するテスト
     *
     * @return void
     */
    public function test_getHouseworkIndex()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);
        $houseworks = Housework::factory(3)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // 実行
        $response = $this->actingAs($user)->getJson('/api/houseworks');
        $response
            ->assertOK()
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment([
                'title' => $houseworks[0]->title,
            ]);
    }
}
