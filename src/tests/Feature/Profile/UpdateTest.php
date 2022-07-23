<?php

namespace Tests\Feature\Profile;

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
        Profile::factory()->create(['user_id' => $user->id]);
        $genderList = ['0', '1', '2', '9'];
        $data = [
            'user_id' => $user->id,
            'last_name' => '更新後の姓',
            'first_name' => '更新後の名',
            'gender' => $genderList[array_rand($genderList)],
            'birth' => now()->format('Ymd'),
            'tel' => '09011112222',
            'zipcode' => '100-0000',
            'prefecture' => (string) array_rand(range(1, 47)),
            'city' => '更新後の都市',
            'street_address' => '更新後の住所',
        ];
        // 実行
        $response = $this->actingAs($user)->patchJson('api/profiles', $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('profiles', $data);
    }
}
