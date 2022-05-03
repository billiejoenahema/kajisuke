<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $categories = Category::factory()->count(10)->create();
        foreach($categories as $category) {
            Housework::factory()->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
