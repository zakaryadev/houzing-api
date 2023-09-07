<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
	public function run(): void
	{
		Categories::factory()->count(7)->create();
	}
}
