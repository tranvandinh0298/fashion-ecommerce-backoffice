<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostTagController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/login', [AuthController::class, 'login'])->name("login");
Route::post('/login', [AuthController::class, 'authenticate']);

Route::prefix("admin")->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');
    Route::get('/file-manager', [FileController::class, 'index'])->name('file-manager');

    // user route
    Route::resource('users', UserController::class);
    // Banner
    // Route::resource('banner', BannerController::class);
    Route::prefix("banners")->group(function () {
        Route::get("/", [BannerController::class, 'index'])->name("banners.index");
        Route::get("/ajax-get-banners", [BannerController::class, 'getBanners'])->name("banners.get");
        Route::get("/create", [BannerController::class, 'create'])->name("banners.create");
        Route::post("/", [BannerController::class, 'store'])->name("banners.store");
        Route::get("/{id}", [BannerController::class, 'show'])->name("banners.show");
        Route::get("/{id}/edit", [BannerController::class, 'edit'])->name("banners.edit");
        Route::patch("/{id}", [BannerController::class, 'update'])->name("banners.update");
        Route::delete("/{id}", [BannerController::class, 'destroy'])->name("banners.destroy");
    });
    // Brand
    Route::resource('brand', BrandController::class);
    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', CategoryController::class);
    // Product
    Route::resource('/product', ProductController::class);
    // Ajax for sub category
    Route::post('/category/{id}/child', [CategoryController::class, 'getChildByParent']);
    // POST category
    Route::resource('/post-category', PostCategoryController::class);
    // Post tag
    Route::resource('/post-tag', PostTagController::class);
    // Post
    Route::resource('/post', PostController::class);
    // Message
    Route::resource('/message', MessageController::class);
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');

    // Order
    Route::resource('/order', OrderController::class);
    // Shipping
    Route::resource('/shipping', ShippingController::class);
    // Coupon
    Route::resource('/coupon', CouponController::class);
    // Settings
    Route::get('settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('setting/update', [DashboardController::class, 'settingsUpdate'])->name('settings.update');

    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
    // Password Change
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [DashboardController::class, 'changPasswordStore'])->name('change.password');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
