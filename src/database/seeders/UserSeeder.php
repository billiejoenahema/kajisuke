<?php

namespace Database\Seeders;

use App\Models\HouseworkOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory([
            'name' => 'example',
            'email' => 'example@example.com'
        ])->create();

        HouseworkOrder::create([
            'user_id' => $user->id,
            'order' => '0',
        ]);
    }
}
