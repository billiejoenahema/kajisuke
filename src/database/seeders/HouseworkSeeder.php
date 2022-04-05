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
        Housework::factory()->count(10)->create();
    }
}
