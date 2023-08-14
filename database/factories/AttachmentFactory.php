<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttachmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'img_path' => $this->faker->imageUrl(),
        ];
    }
}
