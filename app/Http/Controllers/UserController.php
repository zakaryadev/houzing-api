<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserProfileResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(30);
        return UserProfileResource::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserProfileResource($user);
    }
}
