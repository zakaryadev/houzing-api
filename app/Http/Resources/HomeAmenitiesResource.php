<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeAmenitiesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'additional' => $this->resource->additional,
            'busStop' => trueOrFalse($this->bus_stop), // Helper function from app\Helper.php
            'garden' => trueOrFalse($this->garden),
            'market' => trueOrFalse($this->market),
            'park' => trueOrFalse($this->park),
            'parking' => trueOrFalse($this->parking),
            'school' => trueOrFalse($this->school),
            'stadium' => trueOrFalse($this->stadium),
            'subway' => trueOrFalse($this->subway),
            'superMarket' => trueOrFalse($this->super_market),
        ];
    }
}
