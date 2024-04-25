<?php

use Illuminate\Support\Facades\Route;
use Webkul\CozaStore\Http\Controllers\Admin\CozaStoreController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/cozastore'], function () {
    Route::controller(CozaStoreController::class)->group(function () {
        Route::get('', 'index')->name('admin.cozastore.index');
    });
});