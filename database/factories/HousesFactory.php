<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categories;
use App\Models\HomeAmenities;
use App\Models\HouseComponents;
use App\Models\HouseDetails;
use App\Models\Location;
use App\Models\User;

class HousesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'user_id' => User::factory(),
            'house_details_id' => HouseDetails::factory(),
            'home_amenities_id' => HomeAmenities::factory(),
            'house_components_id' => HouseComponents::factory(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'sale_price' => $this->faker->numberBetween(100000, 1000000),
            'location_id' => Location::factory(),
            'adress' => $this->faker->address,
            'city' => $this->faker->city,
            'region' => $this->faker->state,
            'country' => $this->faker->country,
            'zip_code' => $this->faker->postcode,
            'categories_id' => rand(1, 7),
            'status' => $this->faker->boolean(),
        ];
    }
}
