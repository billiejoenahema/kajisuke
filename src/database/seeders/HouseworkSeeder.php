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
            $housework = Housework::factory()->create();
            $housework->categories()->attach($category->id);
        }
    }
}
