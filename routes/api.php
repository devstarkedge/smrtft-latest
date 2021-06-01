<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\Apicontroller;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [Apicontroller::class, 'createUser'])->name('createUser');
Route::post('/login', [Apicontroller::class, 'userLogin'])->name('userlogin');
Route::post('/logout', [Apicontroller::class, 'logout'])->name('logout');
Route::post('/categorylist', [Apicontroller::class, 'categoryList'])->name('categoryList');