<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリを削除できることを確認するテスト
     *
     * @return void
     */
    public function test_deleteCategory()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        // 実行
        $response = $this->actingAs($user)->deleteJson('/api/categories/'.$category->id);
        $response->assertStatus(200);
        $this->assertDatabaseCount('categories', 0);
    }
}
