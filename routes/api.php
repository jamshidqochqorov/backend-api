<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('logout',[AuthController::class,'logout']);

    Route::apiResources([
        'category'=>CategoryController::class,
        'product'=>ProductController::class
    ]);
    Route::post('/products/update',[ProductController::class,'updateProduct']);
});
//Public routes
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

