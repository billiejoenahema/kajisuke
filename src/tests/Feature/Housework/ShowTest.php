<?php

declare(strict_types=1);

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 指定した家事を取得できることを確認するテスト
     *
     * @return void
     */
    public function test_getHouseworkOwnerName()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);
        $housework = Housework::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // 実行

        $response = $this->actingAs($user)->getJson('/api/houseworks/' . $housework->id . '/name');
        $response
            ->assertOK()
            ->assertJsonFragment([
                'user_name' => $user->name,
            ]);
    }

    /**
     * 指定した家事を取得できることを確認するテスト
     *
     * @return void
     */
    public function test_getHouseworkShow()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);
        $housework = Housework::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // 実行
        $response = $this->actingAs($user)->getJson('/api/houseworks/' . $housework->id);
        $response
            ->assertOK()
            ->assertJsonFragment([
                'title' => $housework->title,
            ]);

        $this->assertDatabaseCount('houseworks', 1);
    }
}
