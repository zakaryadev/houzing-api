<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'room' => $this->num_rooms,
            'bath' => $this->num_bath,
            'garage' => $this->num_garage,
            'beds' => $this->num_beds,
            'area' => $this->area,
            'yearBuilt' => $this->year_built,
        ];
    }
}
