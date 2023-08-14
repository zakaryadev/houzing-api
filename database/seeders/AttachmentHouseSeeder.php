<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\AttachmentHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentHouseSeeder extends Seeder
{
    public function run(): void
    {
        AttachmentHouse::factory()
            ->count(100)
            ->create();
    }
}
