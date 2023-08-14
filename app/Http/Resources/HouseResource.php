<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'attachments' => AttachmentResource::collection($this->attachments),
            'user' => UserResource::make($this->user),
            'houseDetails' => HouseDetailsResource::make($this->house_details),
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'location' => LocationResource::make($this->location),
            'adress' => $this->adress,
            'city' => $this->city,
            'region' => $this->region,
            'country' => $this->country,
            'zipCode' => $this->zip_code,
            'category' => CategoriesResource::make($this->categories),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
