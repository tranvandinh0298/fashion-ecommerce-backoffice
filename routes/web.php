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
use App\Http\Controllers\Admin\ReviewController;
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
    // Route::resource('brand', BrandController::class);
    Route::prefix("brands")->group(function () {
        Route::get("/", [BrandController::class, 'index'])->name("brands.index");
        Route::get("/ajax-get-brands", [BrandController::class, 'getBrands'])->name("brands.get");
        Route::get("/create", [BrandController::class, 'create'])->name("brands.create");
        Route::post("/", [BrandController::class, 'store'])->name("brands.store");
        Route::get("/{id}", [BrandController::class, 'show'])->name("brands.show");
        Route::get("/{id}/edit", [BrandController::class, 'edit'])->name("brands.edit");
        Route::patch("/{id}", [BrandController::class, 'update'])->name("brands.update");
        Route::delete("/{id}", [BrandController::class, 'destroy'])->name("brands.destroy");
    });
    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile-update');
    // Category
    // Route::resource('/category', CategoryController::class);
    Route::prefix("categories")->group(function () {
        Route::get("/", [CategoryController::class, 'index'])->name("categories.index");
        Route::get("/ajax-get-categories", [CategoryController::class, 'getCategories'])->name("categories.get");
        Route::get("/create", [CategoryController::class, 'create'])->name("categories.create");
        Route::post("/", [CategoryController::class, 'store'])->name("categories.store");
        Route::prefix("/{id}")->group(function () {
            Route::get("/", [CategoryController::class, 'show'])->name("categories.show");
            Route::get("/child-categories", [CategoryController::class, 'getChildParentByParentCategoryId'])->name("categories.childs");
        });
        Route::get("/{id}/edit", [CategoryController::class, 'edit'])->name("categories.edit");
        Route::patch("/{id}", [CategoryController::class, 'update'])->name("categories.update");
        Route::delete("/{id}", [CategoryController::class, 'destroy'])->name("categories.destroy");
    });
    // Product
    // Route::resource('/product', ProductController::class);
    Route::prefix("products")->group(function () {
        Route::get("/", [ProductController::class, 'index'])->name("products.index");
        Route::get("/ajax-get-products", [ProductController::class, 'getProducts'])->name("products.get");
        Route::get("/create", [ProductController::class, 'create'])->name("products.create");
        Route::post("/", [ProductController::class, 'store'])->name("products.store");
        Route::get("/{id}", [ProductController::class, 'show'])->name("products.show");
        Route::get("/{id}/edit", [ProductController::class, 'edit'])->name("products.edit");
        Route::patch("/{id}", [ProductController::class, 'update'])->name("products.update");
        Route::delete("/{id}", [ProductController::class, 'destroy'])->name("products.destroy");
    });

    // Ajax for sub category
    // Route::post('/category/{id}/child', [CategoryController::class, 'getChildByParent']);
    // POST category
    // Route::resource('/post-category', PostCategoryController::class);
    Route::prefix("post-categories")->group(function () {
        Route::get("/", [PostCategoryController::class, 'index'])->name("postCategories.index");
        Route::get("/ajax-get-post-categories", [PostCategoryController::class, 'getPostCategories'])->name("postCategories.get");
        Route::get("/create", [PostCategoryController::class, 'create'])->name("postCategories.create");
        Route::post("/", [PostCategoryController::class, 'store'])->name("postCategories.store");
        Route::get("/{id}", [PostCategoryController::class, 'show'])->name("postCategories.show");
        Route::get("/{id}/edit", [PostCategoryController::class, 'edit'])->name("postCategories.edit");
        Route::patch("/{id}", [PostCategoryController::class, 'update'])->name("postCategories.update");
        Route::delete("/{id}", [PostCategoryController::class, 'destroy'])->name("postCategories.destroy");
    });
    // Post tag
    // Route::resource('/post-tag', PostTagController::class);
    Route::prefix("post-tags")->group(function () {
        Route::get("/", [PostTagController::class, 'index'])->name("postTags.index");
        Route::get("/ajax-get-post-tags", [PostTagController::class, 'getPostTags'])->name("postTags.get");
        Route::get("/create", [PostTagController::class, 'create'])->name("postTags.create");
        Route::post("/", [PostTagController::class, 'store'])->name("postTags.store");
        Route::get("/{id}", [PostTagController::class, 'show'])->name("postTags.show");
        Route::get("/{id}/edit", [PostTagController::class, 'edit'])->name("postTags.edit");
        Route::patch("/{id}", [PostTagController::class, 'update'])->name("postTags.update");
        Route::delete("/{id}", [PostTagController::class, 'destroy'])->name("postTags.destroy");
    });
    // Post
    // Route::resource('/post', PostController::class);
    Route::prefix("posts")->group(function () {
        Route::get("/", [PostController::class, 'index'])->name("posts.index");
        Route::get("/ajax-get-posts", [PostController::class, 'getPosts'])->name("posts.get");
        Route::get("/create", [PostController::class, 'create'])->name("posts.create");
        Route::post("/", [PostController::class, 'store'])->name("posts.store");
        Route::get("/{id}", [PostController::class, 'show'])->name("posts.show");
        Route::get("/{id}/edit", [PostController::class, 'edit'])->name("posts.edit");
        Route::patch("/{id}", [PostController::class, 'update'])->name("posts.update");
        Route::delete("/{id}", [PostController::class, 'destroy'])->name("posts.destroy");
    });

    // Message
    Route::resource('/message', MessageController::class);
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');

    // Order
    // Route::resource('/order', OrderController::class);
    Route::prefix("orders")->group(function () {
        Route::get("/", [OrderController::class, 'index'])->name("orders.index");
        Route::get("/ajax-get-orders", [OrderController::class, 'getOrders'])->name("orders.get");
        Route::get("/create", [OrderController::class, 'create'])->name("orders.create");
        Route::post("/", [OrderController::class, 'store'])->name("orders.store");
        Route::get("/{id}", [OrderController::class, 'show'])->name("orders.show");
        Route::get("/{id}/edit", [OrderController::class, 'edit'])->name("orders.edit");
        Route::patch("/{id}", [OrderController::class, 'update'])->name("orders.update");
        Route::delete("/{id}", [OrderController::class, 'destroy'])->name("orders.destroy");
    });

    // Shipping
    // Route::resource('/shipping', ShippingController::class);
    Route::prefix("shippings")->group(function () {
        Route::get("/", [ShippingController::class, 'index'])->name("shippings.index");
        Route::get("/ajax-get-shippings", [ShippingController::class, 'getShippings'])->name("shippings.get");
        Route::get("/create", [ShippingController::class, 'create'])->name("shippings.create");
        Route::post("/", [ShippingController::class, 'store'])->name("shippings.store");
        Route::get("/{id}", [ShippingController::class, 'show'])->name("shippings.show");
        Route::get("/{id}/edit", [ShippingController::class, 'edit'])->name("shippings.edit");
        Route::patch("/{id}", [ShippingController::class, 'update'])->name("shippings.update");
        Route::delete("/{id}", [ShippingController::class, 'destroy'])->name("shippings.destroy");
    });
    // Coupon
    // Route::resource('/coupon', CouponController::class);
    Route::prefix("coupons")->group(function () {
        Route::get("/", [CouponController::class, 'index'])->name("coupons.index");
        Route::get("/ajax-get-coupons", [CouponController::class, 'getCoupons'])->name("coupons.get");
        Route::get("/create", [CouponController::class, 'create'])->name("coupons.create");
        Route::post("/", [CouponController::class, 'store'])->name("coupons.store");
        Route::get("/{id}", [CouponController::class, 'show'])->name("coupons.show");
        Route::get("/{id}/edit", [CouponController::class, 'edit'])->name("coupons.edit");
        Route::patch("/{id}", [CouponController::class, 'update'])->name("coupons.update");
        Route::delete("/{id}", [CouponController::class, 'destroy'])->name("coupons.destroy");
    });
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

    // Route::get('/reviews',[ReviewController::class, 'index'])->name("reviews.index");
    Route::prefix("reviews")->group(function () {
        Route::get("/", [ReviewController::class, 'index'])->name("reviews.index");
        Route::get("/ajax-get-reviews", [ReviewController::class, 'getReviews'])->name("reviews.get");
        Route::get("/{id}/edit", [ReviewController::class, 'edit'])->name("reviews.edit");
        Route::patch("/{id}", [ReviewController::class, 'update'])->name("reviews.update");
        Route::delete("/{id}", [ReviewController::class, 'destroy'])->name("reviews.destroy");
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
