<?php

declare(strict_types=1);

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
        $cycleNum = rand(1, 4);

        return [
            'user_id' => 1,
            'category_id' => rand(1, 10),
            'title' => '家事' . rand(1, 99),
            'comment' => 'コメントサンプル' . rand(1, 99),
            'cycle_num' => $cycleNum,
            'cycle_unit' => rand(1, 4),
            'next_date' => now()->addDays($cycleNum),
        ];
    }
}
