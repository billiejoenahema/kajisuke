<?php

namespace Database\Seeders;

use App\Models\Housework;
use Illuminate\Database\Seeder;

class HouseworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Housework::factory([
            'user_id' => 1,
            'title' => '家事サンプル',
            'comment' => 'コメントサンプル',
            'cycle' => '+1 week',
        ])->create();
    }
}
