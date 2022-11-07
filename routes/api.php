<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\VideoManageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:sanctum')->get('/profile',[UserController::class, "profile"]);



Route::middleware('auth:sanctum')->group(function(){
    Route::delete('/logout',[AuthController::class, "logout"]);
    Route::get('/profile',[UserController::class, "profile"]);
    Route::patch('/profile',[UserController::class, "update"]);

    Route::get('/videos/my',[VideoManageController::class, "list"]);
    Route::post('/videos',[VideoManageController::class, "store"]);
    Route::patch('/videos/{video}',[VideoManageController::class, "update"]);
    Route::delete('/videos/{video}',[VideoManageController::class, "delete"]);
    Route::post('/videos/{video}/like',[VideoController::class, "like"]);
});

Route::post('/registration',[AuthController::class, "registration"]);
Route::post('/auth',[AuthController::class, "auth"]);
Route::get('/videos',[VideoController::class, "search"]);
Route::get('/videos/{video}',[VideoController::class, "show"]);