<?php

namespace Tests\Feature\Housework;

use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getHouseworkIndex()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $housework = Housework::factory()->create();

        // 実行
        $response = $this->actingAs($user)->getJson('/api/houseworks');
        $response
        ->assertOK()
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'title' => $housework->title,
        ]);

        $this->assertDatabaseCount('houseworks', 1);
    }
}
