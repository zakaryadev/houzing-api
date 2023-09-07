<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseComponentsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'additional' => $this->resource->additional,
            'airCondition' => trueOrFalse($this->air_condition), // Helper function from app\Helper.php
            'courtyard' => trueOrFalse($this->courtyard),
            'furniture' => trueOrFalse($this->furniture),
            'gas_stove' => trueOrFalse($this->gas_stove),
            'internet' => trueOrFalse($this->internet),
            'tv' => trueOrFalse($this->tv),
        ];
    }
}
