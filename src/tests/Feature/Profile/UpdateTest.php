<?php

declare(strict_types=1);

namespace Tests\Feature\Profile;

use App\Enums\Gender;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィールを更新できることを確認する。
     *
     * @return void
     */
    public function test_updateProfile()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $data = [
            'user_id' => $user->id,
            'image' => 'updated_image.jpg',
            'last_name' => '更新後の姓',
            'first_name' => '更新後の名',
            'gender' => Gender::values()[array_rand(Gender::values())],
            'birth' => now()->format('Y-m-d'),
            'tel' => '09011112222',
            'zipcode1' => '100',
            'zipcode2' => '0000',
            'prefecture' => (string) array_rand(range(1, 47)),
            'city' => '更新後の都市',
            'street_address' => '更新後の住所',
        ];

        // 実行
        $response = $this->actingAs($user)->patchJson("api/profiles/{$profile->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('profiles', $data);
    }
}
