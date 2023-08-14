<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HousesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilterController;

//== houses routes
Route::group(['middleware' => 'api', 'prefix' => 'houses'], function () {
    Route::get('/list', [FilterController::class, 'list'])->name('houses.list');
    Route::get('/id/{id}', [HousesController::class, 'show'])->name('houses.show');
    Route::post('', [HousesController::class, 'store'])->name('houses.store');
    Route::put('/{id}', [HousesController::class, 'update'])->name('houses.update');
    Route::delete('/{id}', [HousesController::class, 'destroy'])->name('houses.destroy');
    Route::get('/categories/{id}', [HousesController::class, 'getByCategory'])->name('houses.getByCategory');
    Route::get('/me', [HousesController::class, 'getByUser'])->name('houses.getByUser');
    Route::put('/addFavourite/{id}', [HousesController::class, 'addFavourite'])->name('houses.addFavourite');
    Route::get('/getAll/favouriteList', [HousesController::class, 'favouriteList'])->name('houses.favouriteList');
});
//== end houses routes

//== categories routes
Route::group(['middleware' => 'api', 'prefix' => 'categories'], function () {
    Route::get('', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/list', [CategoriesController::class, 'list'])->name('categories.list');
    Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
    Route::post('', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});
//== end categories routes

//== users routes
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
//== end users routes

//== auth routes
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
});
//== end auth routes
