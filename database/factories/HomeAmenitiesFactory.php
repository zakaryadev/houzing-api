<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=HomeAmenities>
 */
class HomeAmenitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'additional' => $this->faker->text,
            'bus_stop' => $this->faker->boolean,
            'garden' => $this->faker->boolean,
            'market' => $this->faker->boolean,
            'park' => $this->faker->boolean,
            'parking' => $this->faker->boolean,
            'school' => $this->faker->boolean,
            'stadium' => $this->faker->boolean,
            'subway' => $this->faker->boolean,
            'super_market' => $this->faker->boolean,
        ];
    }
}
