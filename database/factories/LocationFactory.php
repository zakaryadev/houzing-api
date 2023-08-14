<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
        ];
    }
}
