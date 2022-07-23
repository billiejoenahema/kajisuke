<?php

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
                'name' => 'example',
                'email' => 'example@example.com'
            ])->create();

            Profile::create([
                'user_id' => $user->id,
            ]);
        });
    }
}
