<?php

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\Housework;
use App\Models\HouseworkOrder;
use App\Models\User;
use App\Services\HouseworkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事を削除するテスト
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
        $houseworkIds = $housework->pluck('id')->toArray();
        HouseworkOrder::factory()->create([
            'user_id' => $user->id,
            'order' => implode(',', $houseworkIds),
        ]);

        // 実行
        $uri = '/api/houseworks/' . $housework[0]->id;
        $response = $this->actingAs($user)->deleteJson($uri, [
            'id' => $housework[0]->id,
        ]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('houseworks', [
            'id' => $housework[0]->id,
        ]);
    }
}
