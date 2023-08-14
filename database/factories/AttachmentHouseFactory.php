<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Houses;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentHouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'houses_id' => Houses::factory(),
            'attachment_id' => Attachment::factory(),
        ];
    }
}
