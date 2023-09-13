<?php

namespace App\Http\Controllers;

use App\Http\Resources\HouseResource;
use App\Models\Houses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'list']);
    }

    public function list(Request $request): JsonResponse
    {
        $query = Houses::query();
        $adress = $request->query('address');
        $country = $request->query('country');
        $city = $request->query('city');
        $region = $request->query('region');
        $zipCode = $request->query('zip_code');
        $name = $request->query('house_name');
        $category = $request->query('categories_id');
        $sort = $request->query('sort');
        $size = $request->query('size') ?? 10;
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');
        $room = $request->query('room');
        if ($adress) {
            $query->where('adress', 'LIKE', '%' . $adress . '%');
        }
        if ($country) {
            $query->where('country', 'LIKE', '%' . $country . '%');
        }
        if ($city) {
            $query->where('city', 'LIKE', '%' . $city . '%');
        }
        if ($region) {
            $query->where('region', 'LIKE', '%' . $region . '%');
        }
        if ($zipCode) {
            $query->where('zip_code', 'LIKE', '%' . $zipCode . '%');
        }
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($category) {
            $query->where('categories_id', $category);
        }
        if ($min_price) {
            $query->where('price', '>=', $min_price);
        }
        if ($max_price) {
            $query->where('price', '<=', $max_price);
        }
        if ($min_price && $max_price) {
            $query->whereBetween('price', [$min_price, $max_price]);
        }
        if ($size) {
            $query->paginate($size);
        }

        if ($sort) {
            switch ($sort) {
                case 'asc':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'desc':
                    $query->orderBy('price', 'DESC');
                    break;
            }
        }

        $houses = $query->get();
        $houses_count = Houses::count();
        $new_houses = [];
        if ($room) {
            foreach ($houses as $house) {
                if ($house->house_details->num_rooms == $room) {
                    array_push($new_houses, $house);
                }
            }
            $houses = $new_houses;
        }
        return response()->json([
            'success' => true,
            'message' => 'House list',
            'data' => HouseResource::collection($houses),
            'map' => [
                'size' => $size,
                'total_elements' => $houses_count,
                'total_pages' => ceil($houses_count / $size),
            ],
            'status' => 'OK',
        ], 200);
    }
}
