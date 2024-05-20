<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//panggil ProductCT sebagai object
use App\Http\Controllers\ProductCT;
use App\Http\Controllers\CategoriesCT;
use App\Http\Controllers\AuthCT;
use App\Http\Controllers\GoogleAuthCT;

// use App\Models\Categories;

// Api CRUD Product (Create, Read, Update, Delete)
Route::post('/product', [ProductCT::class, 'store']);
Route::get('/product', [ProductCT::class,'show']);
Route::put('/product/{id}', [ProductCT::class,'update']);
Route::delete('/product/{id}', [ProductCT::class,'delete']);

// Api CRUD Categories (Create, Read, Update, Delete)
Route::middleware(['jwt-auth'])->group(function(){
    Route::post('/categories', [CategoriesCT::class, 'store']);
    Route::get('/categories', [CategoriesCT::class,'show']);
    Route::put('/categories/{id}', [CategoriesCT::class,'update']);
    Route::delete('/categories/{id}', [CategoriesCT::class,'delete']);
});


// Api Register & Login
Route::post('/register', [AuthCT::class, 'register']);
Route::post('/login', [AuthCT::class, 'login']);

Route::middleware(['web'])->group(function () {
    Route::get('auth/google', [GoogleAuthCT::class, 'redirect']);
    Route::get('auth/google/callback', [GoogleAuthCT::class, 'callbackGoogle']);
});