<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Houses;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        Houses::factory(10)->create();
    }
}
