<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseDetails>
 */
class HouseDetailsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'num_beds' => $this->faker->numberBetween(1, 10),
            'num_rooms' => $this->faker->numberBetween(1, 10),
            'num_bath' => $this->faker->numberBetween(1, 10),
            'num_garage' => $this->faker->numberBetween(1, 10),
            'area' => $this->faker->numberBetween(100, 1000),
            'year_built' => $this->faker->numberBetween(1900, 2023),
        ];
    }
}
