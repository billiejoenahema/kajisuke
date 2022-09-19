<?php

namespace Tests\Feature\Archive;

use App\Models\Archive;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 家事の履歴を更新できるか
     *
     * @return void
     */
    public function test_updateArchive()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $housework = Housework::factory()->create();
        $archive = Archive::factory()->create([
            'housework_id' => $housework->id,
            'date' => now(),
            'content' => 'テストコンテント',
        ]);

        // 実行
        $uri = '/api/archives/'.$archive->id;
        $response = $this->actingAs($user)->patchJson($uri, [
            'id' => $archive->id,
            'housework_id' => $housework->id,
            'date' => now(),
            'content' => '更新されたコンテント',
        ]);
        $response
        ->assertOK();

        $this->assertDatabaseHas('archives', [
            'content' => '更新されたコンテント',
        ]);
    }
}
