<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $user = User::factory([
                'name' => 'dev_user',
                'email' => 'user@example.com',
                'password' => bcrypt('11111111'),
            ])->create();

            Profile::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
