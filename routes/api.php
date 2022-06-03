<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ApiController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

Route::group(['prefix'=>'category','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('list',[ApiController::class,'categoryList'])->name('category#categoryList');//list
    Route::post('create',[ApiController::class,'createCategory'])->name('category#createCategory');//create
    Route::get('details/{id}',[ApiController::class,'categoryDetail'])->name('category#categoryDetail');//detail
    Route::get('delete/{id}',[ApiController::class,'categoryDelete'])->name('category#categoryDelete');//delete
    Route::post('update',[ApiController::class,'updateCategory'])->name('category#updateCategory');//update
});

Route::group(['middleware'=>'auth:sanctum'],function(){
   Route::get('logout',[AuthController::class,'logout']);
});
