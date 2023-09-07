<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=HouseComponents>
 */
class HouseComponentsFactory extends Factory
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
            'air_condition' => $this->faker->boolean,
            'courtyard' => $this->faker->boolean,
            'furniture' => $this->faker->boolean,
            'gas_stove' => $this->faker->boolean,
            'internet' => $this->faker->boolean,
            'tv' => $this->faker->boolean,
        ];
    }
}
