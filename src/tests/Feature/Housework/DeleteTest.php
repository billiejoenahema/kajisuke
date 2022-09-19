<?php

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事を削除できることを確認するテスト
     *
     * @return void
     */
    public function test_deleteHousework()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $housework = Housework::factory()->count(2)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // 実行
        $uri = '/api/houseworks/'.$housework[0]->id;
        $response = $this->actingAs($user)->deleteJson($uri, [
            'id' => $housework[0]->id,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('houseworks', [
            'id' => $housework[0]->id,
        ]);
    }
}
