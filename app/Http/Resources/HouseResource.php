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
            'user' => UserResource::make($this->user),
            'houseDetails' => HouseDetailsResource::make($this->house_details),
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'location' => LocationResource::make($this->location),
            'address' => $this->adress,
            'city' => $this->city,
            'region' => $this->region,
            'country' => $this->country,
            'zipCode' => $this->zip_code,
            'attachments' => AttachmentResource::collection($this->attachments),
            'category' => CategoriesResource::make($this->categories),
            'status' => $this->status == 0 ? false : true,
            'houseComponentsDto' => HouseComponentsResource::make($this->house_components),
            'homeAmenitiesDto' => HomeAmenitiesResource::make($this->home_amenities),
            'created_at' => $this->created_at->format('d-m-Y | H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y | H:i'),
        ];
    }
}
