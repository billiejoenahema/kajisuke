<?php

declare(strict_types=1);

namespace Tests\Feature\Archive;

use App\Models\Archive;
use App\Models\Housework;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deleteArchive()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $housework = Housework::factory()->create([
            'user_id' => $user->id,
        ]);
        $archive = Archive::factory()->create([
            'housework_id' => $housework->id,
        ]);
        // 実行
        $uri = '/api/archives/' . $archive->id;
        $response = $this->actingAs($user)
            ->deleteJson($uri);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('archives', $archive->toArray());
    }
}
