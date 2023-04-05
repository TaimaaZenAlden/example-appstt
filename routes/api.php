<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Route::resource('/product', ProductsController::class);     ---  php artisan route:list

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('/get', [ProductsController::class , 'index']);
Route::get('/getusers', [AuthController::class , 'index']);

Route::get('/product/{id}',[ProductsController::class,'show']);
Route::get('product/search/{name}',[ProductsController::class,'search']);
 Route::post('/add', [ProductsController::class, 'store']
 // return Products::create([
   // 'name'=> 'dress',
  //  'color' => 'blue',
   // 'description' => 'good',
  //  'price' =>'80',
  // ]);
);

//protected Route
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/logout',[AuthController::class,'logout']);
    Route::put('/product/{id}',[ProductsController::class,'update']);
    Route::delete('product/{num}',[ProductsController::class,'destroy']);
 Route::delete('user/{num}',[AuthController::class,'destroy']);

});

