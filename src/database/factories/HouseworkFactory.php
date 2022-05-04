<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Housework>
 */
class HouseworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cycles = ['day', 'week', 'month', 'year'];
        return [
            'user_id' => 1,
            'title' => '家事' . rand(1,99),
            'comment' => 'コメントサンプル' . rand(1,99),
            'cycle' => '+' . rand(1, 4) . ' ' . $cycles[array_rand($cycles)],
            'category_id' => rand(1, 10),
        ];
    }
}
