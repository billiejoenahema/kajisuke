<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリ一覧を取得できることを確認するテスト
     *
     * @return void
     */
    public function test_indexCategory()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        Category::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }
}
