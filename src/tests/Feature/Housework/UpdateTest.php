<?php

namespace Tests\Feature\Housework;

use App\Http\Requests\Housework\UpdateRequest;
use App\Models\Category;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事を更新できることを確認するテスト
     *
     * @param UpdateRequest $request
     * @return void
     */
    public function test_updateHousework()
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

        $data = [
            'category_id' => $category->id,
            'title' => 'テストタイトル',
            'comment' => 'テストコメント',
            'cycle_num' => rand(1, 31),
            'cycle_unit' => rand(1, 4),
            'next_date' => now()->addWeek(),
        ];

        // 実行
        $uri = '/api/houseworks/' . $housework->id;
        $response = $this->actingAs($user)->patchJson($uri, $data);
        $response->assertOk();
        $request = new UpdateRequest();

        $this->assertDatabaseHas('houseworks', [
            'id' => $housework->id,
            'title' => $data['title'],
            'comment' => $data['comment'],
            'cycle_num' => $data['cycle_num'],
            'cycle_unit' => $data['cycle_unit'],
            'next_date' => $request->nextDate($data['next_date']),
        ]);
    }
}
