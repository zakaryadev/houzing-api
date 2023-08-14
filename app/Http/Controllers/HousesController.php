<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseStoreRequest;
use App\Http\Requests\HouseUpdateRequest;
use App\Http\Resources\HouseResource;
use App\Models\Attachment;
use App\Models\Categories;
use App\Models\Favourite;
use App\Models\HouseDetails;
use App\Models\Houses;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HousesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'getByCategory', 'list']]);
    }

    // public function index(Request $request)
    // {
    //     $query = Houses::query();
    //     $adress = $request->query('adress');
    //     $country = $request->query('country');
    //     $city = $request->query('city');
    //     $region = $request->query('region');
    //     $zipCode = $request->query('zip_code');
    //     $name = $request->query('name');
    //     $category = $request->query('categories_id');
    //     $orderBy = $request->query('orderBy');
    //     $sortBy = $request->query('sort');
    //     $limit = $request->query('size');
    //     $min_price = $request->query('min_price');
    //     $max_price = $request->query('max_price');
    //     if ($adress) {
    //         $query->where('adress', 'LIKE', '%' . $adress . '%');
    //     }
    //     if ($country) {
    //         $query->where('country', 'LIKE', '%' . $country . '%');
    //     }
    //     if ($city) {
    //         $query->where('city', 'LIKE', '%' . $city . '%');
    //     }
    //     if ($region) {
    //         $query->where('region', 'LIKE', '%' . $region . '%');
    //     }
    //     if ($zipCode) {
    //         $query->where('zip_code', 'LIKE', '%' . $zipCode . '%');
    //     }
    //     if ($name) {
    //         $query->where('name', 'LIKE', '%' . $name . '%');
    //     }
    //     if ($orderBy && $sortBy) {
    //         $query->orderBy($orderBy, $sortBy);
    //     }
    //     if ($category) {
    //         $query->where('categories_id', $category);
    //     }
    //     if ($limit) {
    //         $query->paginate($limit);
    //     }
    //     if ($min_price) {
    //         $query->where('price', '>=', $min_price);
    //     }
    //     if ($max_price) {
    //         $query->where('price', '<=', $max_price);
    //     }
    //     if ($min_price && $max_price) {
    //         $query->whereBetween('price', [$min_price, $max_price]);
    //     }
    //     $house = $query->get();
    //     return HouseResource::collection($house);
    // }

    public function show($id)
    {
        $house = Houses::findOrFail($id);
        return new HouseResource($house);
    }

    public function store(Request $request)
    {
        $token = $request->bearerToken();
        $user = Auth::user();
        if (!$user || !$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        } else {
            $house = Houses::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'sale_price' => $request->salePrice,
                'adress' => $request->adress,
                'city' => $request->city,
                'region' => $request->region,
                'country' => $request->country,
                'zip_code' => $request->zipCode,
                'categories_id' => $request->categories_id,
                'user_id' => Auth::user()->id,
                'status' => $request->status,
                'location_id' => Location::create([
                    'lat' => ($request->locations)['lat'],
                    'long' => ($request->locations)['long']
                ])->id,
                'house_details_id' => HouseDetails::create([
                    'num_beds' => ($request->houseDetails)['beds'],
                    'num_rooms' => ($request->houseDetails)['room'],
                    'num_bath' => ($request->houseDetails)['bath'],
                    'num_garage' => ($request->houseDetails)['garage'],
                    'area' => ($request->houseDetails)['area'],
                    'year_built' => ($request->houseDetails)['yearBuilt'],
                ])->id,
            ]);
            if (isset($request->attachments)) {
                foreach ($request->attachments as $attachmentData) {
                    $attachment = Attachment::create([
                        'img_path' => $attachmentData['img_path'],
                    ]);
                    $house->attachments()->attach($attachment->id);
                }
            }
            return response()->json([
                'message' => 'House created successfully',
                'house' => new HouseResource($house)
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $house = Houses::findOrFail($id);
        $location = Location::find($house->location_id);
        $houseDetails = HouseDetails::find($house->house_details_id);
        $house_attachments = $house->attachments;

        $token = $request->bearerToken();
        $user = Auth::user();
        if (!$user || !$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        } elseif ($house->user_id == $user->id) {
            $house->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'sale_price' => $request->salePrice,
                'adress' => $request->adress,
                'city' => $request->city,
                'region' => $request->region,
                'country' => $request->country,
                'zip_code' => $request->zipCode,
                'categories_id' => $request->categories_id,
                'status' => $request->status,
            ]);
            $location->update([
                'lat' => $request->location['lat'],
                'long' => $request->location['long']
            ]);
            $houseDetails->update([
                'num_beds' => $request->houseDetails['beds'],
                'num_rooms' => $request->houseDetails['rooms'],
                'num_bath' => $request->houseDetails['bath'],
                'num_garage' => $request->houseDetails['garage'],
                'area' => $request->houseDetails['area'],
                'year_built' => $request->houseDetails['yearBuilt'],
            ]);
            if (isset($house->attachments)) {
                foreach ($house_attachments as $attachment) {
                    $attachment->delete();
                }
            }
            if (isset($request->attachments)) {
                foreach ($request->attachments as $attachmentData) {
                    $attachment = Attachment::create([
                        'img_path' => $attachmentData['imgPath'],
                    ]);

                    $house->attachments()->attach($attachment->id);
                }
            }
            return response()->json([
                'message' => 'House updated successfully',
                'house' => new HouseResource($house)
            ], 201);
        } else {
            return response()->json([
                'message' => 'Don\'t have permission to update this house',
            ], 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $token = $request->bearerToken();
        $user = Auth::user();
        $house = Houses::findOrFail($id);
        if (!$user || !$token) {
            return response()->json([
                'message' => 'Don\'t have permission to delete this house',
            ], 200);
        } else {
            $house->delete();
            return response()->json([
                'message' => 'House deleted successfully'
            ], 200);
        }
    }

    public function getByCategory($id)
    {
        $houses = Categories::find($id)->houses;
        return response()->json([
            'category' => Categories::find($id)->name,
            'data' => HouseResource::collection($houses),
            'total' => $houses->count()
        ], 200);
    }

    public function getByUser(Request $request)
    {
        $token = request()->bearerToken();
        $user = Auth::user();
        if (!$user || !$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        } else {
            $houses = Houses::where('user_id', $user->id)->get();
            return response()->json([
                'data' => HouseResource::collection($houses),
                'total' => $houses->count()
            ], 200);
        }
    }

    public function addFavourite(Request $request, $id)
    {
        $house = Houses::find($id);
        $token = $request->bearerToken();
        $user = Auth::user();

        if (!$user || !$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        } else {
            Favourite::create([
                'user_id' => $user->id,
                'house_id' => $house->id
            ]);
            return response()->json([
                'message' => 'House added to favourites'
            ], 200);
        }
    }

    public function favouriteList(Request $request)
    {
        $token = request()->bearerToken();
        $user = Auth::user();
        if (!$user || !$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        } else {
            $favourites = $user->favourites;
            $houses = [];
            foreach ($favourites as $favourite) {
                array_push($houses, $favourite->house);
            }
            return response()->json([
                'data' => HouseResource::collection($houses),
                'total' => $favourites->count()
            ], 200);
        }
    }
}
