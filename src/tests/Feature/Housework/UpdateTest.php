<?php

namespace Tests\Feature\Housework;

use App\Models\Category;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateHousework()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $housework = Housework::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // 実行
        $uri = '/api/houseworks/' . $housework->id;
        $response = $this->actingAs($user)->patchJson($uri, [
            'id' =>$housework->id,
            'category_id' => $category->id,
            'title' => 'テストタイトル',
            'comment' => 'テストコメント',
            'cycle_num' => '+1',
            'cycle_unit' => 'week',
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('houseworks', [
            'id' => $housework->id,
            'title' => 'テストタイトル',
            'comment' => 'テストコメント',
            'cycle' => '+1 week',
        ]);
    }
}
