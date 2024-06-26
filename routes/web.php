<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", [DashboardController::class, "index"]);

Route::prefix('images')->group(function () {
    Route::get("/", [ImageController::class, "index"]);
    Route::get("/create", [ImageController::class, "create"]);
    Route::post("/store", [ImageController::class, "store"]);
    Route::get("/delete", [ImageController::class, "destroy"]);
});

Route::prefix('categories')->group(function () {
    Route::get("/", [CategoryController::class, "index"]);
    Route::get("/create", [CategoryController::class, "create"]);
    Route::post("/store", [CategoryController::class, "store"]);
});
