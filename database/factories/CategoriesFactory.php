<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['House', 'Apartment', 'Room', 'Villa', 'Cottage', 'Earth House', 'Other'];
        return [
            'name' => $this->faker->randomElement($categories),
        ];
    }
}
