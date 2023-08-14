<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesListResource;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'list']]);
    }

    public function index(Request $request)
    {
        $page = $request->query('page') ?? 1;
        $limit = $request->query('size') ?? 10;
        $categories = Categories::limit($limit)->offset(($page - 1) * $limit)->get();
        return CategoriesListResource::collection($categories);
    }

    public function show($id)
    {
        $categories = Categories::find($id);
        if ($categories) {
            return new CategoriesResource($categories);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $token = $request->bearerToken();
        $user = auth()->user();
        if (!$token || !$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $category = Categories::create($request->all());
            return response()->json([
                'message' => 'Category created successfully',
                'category' => new CategoriesResource($category)
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);
        $token = $request->bearerToken();
        $user = auth()->user();
        if (!$token || !$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $category->update($request->all());
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => new CategoriesResource($category)
            ], 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $category = Categories::findOrFail($id);
        $token = $request->bearerToken();
        $user = auth()->user();
        if (!$token || !$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $category->delete();
            return response()->json(null, 204);
        }
    }

    public function list()
    {
        return CategoriesListResource::collection(Categories::all());
    }
}
