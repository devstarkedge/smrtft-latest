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
Route::post('/subcategorylist', [Apicontroller::class, 'subCategoryList'])->name('subcategorylist');
Route::post('/trainerlist', [Apicontroller::class, 'trainerList'])->name('trainerlist');
Route::post('/logout', [Apicontroller::class, 'logout'])->name('logout');
Route::post('/workoutlist', [Apicontroller::class, 'workoutList'])->name('workoutlist');
Route::post('/workoutlistbysubcategory', [Apicontroller::class, 'workoutListBySubCategory'])->name('workoutlistbysubcategory');
Route::post('/profileupdate', [Apicontroller::class, 'profileUpdate'])->name('profileupdate');
Route::post('/addfavouriteworkout', [Apicontroller::class, 'addFavouriteWorkout'])->name('addfavouriteworkout');
Route::post('/favouriteworkoutlist', [Apicontroller::class, 'favouriteWorkoutList'])->name('favouriteworkoutlist');
Route::post('/programlist', [Apicontroller::class, 'programList'])->name('programlist');
Route::post('/programlistbytrainer', [Apicontroller::class, 'programListByTrainer'])->name('programlistbytrainer');
Route::post('/programdetails', [Apicontroller::class, 'programDetails'])->name('programdetails');
Route::post('/addprogramrecord',[Apicontroller::class, 'addProgramRecord'])->name('addprogramrecord');
Route::post('/forgetpassword',[Apicontroller::class, 'forgetPassword'])->name('forgetpassword');
Route::post('/resetpassword',[Apicontroller::class, 'resetPassword'])->name('resetpassword');
Route::post('/progressreport',[Apicontroller::class, 'progressReport'])->name('progressreport');
Route::post('/add-shopify-user',[Apicontroller::class, 'addShopifyUser'])->name('addshopifyuser');
Route::post('/view-workout',[Apicontroller::class, 'viewWorkout'])->name('viewworkout');
Route::post('/add-workout-record',[Apicontroller::class, 'addWorkoutRecord'])->name('addworkoutrecord');
Route::post('/exerciseslist', [Apicontroller::class, 'exercisesList'])->name('exerciseslist');
Route::post('/exerciseaddtolike', [Apicontroller::class, 'exercisesAddToLike'])->name('exerciseaddtolike');
Route::post('/exerciselikelist', [Apicontroller::class, 'exercisesLikeList'])->name('exerciselikelist');
