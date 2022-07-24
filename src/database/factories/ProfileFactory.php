<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'gender' => array_rand(['0', '1', '2', '9']),
            'birth' => now()->format('Y-m-d'),
            'tel' => '0' . random_int(100000000, 999999999),
            'zipcode' => $this->faker->postcode,
            'prefecture' => (string) array_rand(range(1, 47)),
            'city' => $this->faker->city,
            'street_address' => $this->faker->streetAddress,
        ];
    }
}
