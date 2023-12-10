<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリを更新できることを確認するテスト
     *
     * @return void
     */
    public function test_UpdateCategory()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->patchJson('/api/categories/' . $category->id, [
            'name' => '更新したカテゴリ',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', [
            'name' => '更新したカテゴリ',
        ]);
    }
}
