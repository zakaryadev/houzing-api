<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\HouseStoreRequest;
    use App\Http\Requests\HouseUpdateRequest;
    use App\Http\Resources\HouseResource;
    use App\Models\Attachment;
    use App\Models\Categories;
    use App\Models\Favourite;
    use App\Models\HomeAmenities;
    use App\Models\HouseComponents;
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

        public function show($id)
        {
            $house = Houses::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'House',
                'data' => HouseResource::make($house),
                'status' => 'OK'
            ], 200);
        }

        public function store(Request $request)
        {
            $house_details_validation = $request->validate([
                'houseDetails.beds' => 'required|integer',
                'houseDetails.room' => 'required|integer',
                'houseDetails.bath' => 'required|integer',
                'houseDetails.garage' => 'required|integer',
                'houseDetails.area' => 'required|integer',
                'houseDetails.yearBuilt' => 'required|integer',
            ]);
            $home_amenities_validation = $request->validate([
                'homeAmenitiesDto.additional' => 'required|string',
                'homeAmenitiesDto.busStop' => 'required|boolean',
                'homeAmenitiesDto.garden' => 'required|boolean',
                'homeAmenitiesDto.market' => 'required|boolean',
                'homeAmenitiesDto.park' => 'required|boolean',
                'homeAmenitiesDto.parking' => 'required|boolean',
                'homeAmenitiesDto.school' => 'required|boolean',
                'homeAmenitiesDto.stadium' => 'required|boolean',
                'homeAmenitiesDto.subway' => 'required|boolean',
                'homeAmenitiesDto.superMarket' => 'required|boolean',
            ]);
            $house_components_validation = $request->validate([
                'componentsDto.additional' => 'required|string',
                'componentsDto.airCondition' => 'required|boolean',
                'componentsDto.courtyard' => 'required|boolean',
                'componentsDto.furniture' => 'required|boolean',
                'componentsDto.gasStove' => 'required|boolean',
                'componentsDto.internet' => 'required|boolean',
                'componentsDto.tv' => 'required|boolean',
            ]);

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
                    'adress' => $request->address,
                    'city' => $request->city,
                    'region' => $request->region,
                    'country' => $request->country,
                    'zip_code' => $request->zipCode,
                    'categories_id' => $request->categoryId,
                    'user_id' => Auth::user()->id,
                    'status' => $request->status,
                    'location_id' => Location::create([
                        'lat' => ($request->locations)['latitude'],
                        'long' => ($request->locations)['longitude']
                    ])->id,
                    'house_components_id' => HouseComponents::create([
                        'additional' => $house_components_validation['componentsDto']['additional'],
                        'air_condition' => $house_components_validation['componentsDto']['airCondition'],
                        'courtyard' => $house_components_validation['componentsDto']['courtyard'],
                        'furniture' => $house_components_validation['componentsDto']['furniture'],
                        'gas_stove' => $house_components_validation['componentsDto']['gasStove'],
                        'internet' => $house_components_validation['componentsDto']['internet'],
                        'tv' => $house_components_validation['componentsDto']['tv'],
                    ])->id,
                    'house_details_id' => HouseDetails::create([
                        'num_beds' => $house_details_validation['houseDetails']['beds'],
                        'num_rooms' => $house_details_validation['houseDetails']['room'],
                        'num_bath' => $house_details_validation['houseDetails']['bath'],
                        'num_garage' => $house_details_validation['houseDetails']['garage'],
                        'area' => $house_details_validation['houseDetails']['area'],
                        'year_built' => $house_details_validation['houseDetails']['yearBuilt'],
                    ])->id,
                    'home_amenities_id' => HomeAmenities::create([
                        'additional' => $home_amenities_validation['homeAmenitiesDto']['additional'],
                        'bus_stop' => $home_amenities_validation['homeAmenitiesDto']['busStop'],
                        'garden' => $home_amenities_validation['homeAmenitiesDto']['garden'],
                        'market' => $home_amenities_validation['homeAmenitiesDto']['market'],
                        'park' => $home_amenities_validation['homeAmenitiesDto']['park'],
                        'parking' => $home_amenities_validation['homeAmenitiesDto']['parking'],
                        'school' => $home_amenities_validation['homeAmenitiesDto']['school'],
                        'stadium' => $home_amenities_validation['homeAmenitiesDto']['stadium'],
                        'subway' => $home_amenities_validation['homeAmenitiesDto']['subway'],
                        'super_market' => $home_amenities_validation['homeAmenitiesDto']['superMarket'],
                    ])->id,
                ]);
                if (isset($request->attachments)) {
                    foreach ($request->attachments as $attachmentData) {
                        $attachment = Attachment::create([
                            'img_path' => $attachmentData['imgPath'],
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
