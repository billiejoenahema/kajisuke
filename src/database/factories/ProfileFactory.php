<?php

namespace Database\Factories;

use App\Enums\Gender;
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
            'gender' => Gender::values()[array_rand(Gender::values())],
            'birth' => now()->format('Y-m-d'),
            'tel' => '0'.random_int(100000000, 999999999),
            'zipcode1' => $this->faker->postcode1,
            'zipcode2' => $this->faker->postcode2,
            'prefecture' => (string) array_rand(range(1, 47)),
            'city' => $this->faker->city,
            'street_address' => $this->faker->streetAddress,
        ];
    }
}
