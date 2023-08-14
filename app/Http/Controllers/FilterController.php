<?php

namespace App\Http\Controllers;

use App\Http\Resources\HouseResource;
use App\Models\Houses;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'list']);
    }

    public function list(Request $request)
    {
        $query = Houses::query();
        $searches = [
            'adress', 'country', 'city', 'region', 'zip_code', 'name',
        ];
        $filters = [
            'categories_id', 'sort', 'size',
            'min_price', 'max_price'
        ];
        foreach ($searches as $search) {
            if ($request->has($search) && strlen($request->$search)) {
                $query =  $query->where(function ($query) use ($request, $search) {
                    $query->where($search, 'LIKE', '%' . $request->$search . '%');
                });
            }
        }
        // $adress = $request->query('adress');
        // $country = $request->query('country');
        // $city = $request->query('city');
        // $region = $request->query('region');
        // $zipCode = $request->query('zip_code');
        // $name = $request->query('house_name');
        $category = $request->query('categories_id');
        $sort = $request->query('sort');
        $limit = $request->query('size');
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');
        // if ($adress) {
        //     $query->where('adress', 'LIKE', '%' . $adress . '%');
        // }
        // if ($country) {
        //     $query->where('country', 'LIKE', '%' . $country . '%');
        // }
        // if ($city) {
        //     $query->where('city', 'LIKE', '%' . $city . '%');
        // }
        // if ($region) {
        //     $query->where('region', 'LIKE', '%' . $region . '%');
        // }
        // if ($zipCode) {
        //     $query->where('zip_code', 'LIKE', '%' . $zipCode . '%');
        // }
        // if ($name) {
        //     $query->where('name', 'LIKE', '%' . $name . '%');
        // }
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
        if ($limit) {
            $query->paginate($limit);
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

        $house = $query->get();
        return response()->json([
            'message' => count(HouseResource::collection($house)) > 0 ? 'success' : 'no data',
            'data' => count(HouseResource::collection($house)) > 0 ? HouseResource::collection($house) : [],
            'total' => $house->count()
        ], 200);
    }
}
