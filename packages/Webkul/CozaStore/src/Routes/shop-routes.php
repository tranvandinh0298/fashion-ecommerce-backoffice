<?php

use Illuminate\Support\Facades\Route;
use Webkul\CozaStore\Http\Controllers\Shop\CozaStoreController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'cozastore'], function () {
    Route::get('', [CozaStoreController::class, 'index'])->name('shop.cozastore.index');
});