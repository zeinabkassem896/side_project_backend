<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'categories'], function(){
    Route::get('/', [CategoryController::class, 'getCategories']);

    Route::get('/{id}', [CategoryController::class, 'getCategoryById']);
    
    Route::post('/', [CategoryController::class, 'createCategory']);

    Route::delete('/{id}', [CategoryController::class, 'deleteCategory']);

    Route::post('/update/{id}', [CategoryController::class, 'updateCategory']);

});

Route::resource('items', ItemController::class);


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


//secured route

Route::group(['middleware' => ['jwt.verify']], function() {
   


});






















