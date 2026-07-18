<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckBlockedUserMiddleware;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// public routes


Route::post('/login', [AuthController::class, 'login']);

//  user routes
Route::post('/register-user', [UserController::class, 'store']);
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    $user = User::findOrFail($id);
    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403, 'Invalid verification link.');
    }
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }
    return redirect('http://localhost:5173/login?verified=true');
})->middleware('signed')->name('verification.verify');

Route::get('/food-items/search', [FoodItemController::class, 'search_food_item']);
// slider routes
Route::get('/sliders', [SliderController::class, 'index']);
Route::apiResource('/food-items', FoodItemController::class)->only(['index', 'show']);
Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);




// protected routes
Route::middleware(['auth:sanctum',CheckBlockedUserMiddleware::class])->group(function () {

    //  Category routes 
    Route::apiResource('/categories', CategoryController::class)->except(['index', 'show']);

    // food items route
    Route::apiResource('/food-items', FoodItemController::class)->except(['index', 'show']);

    // cart routes
    Route::controller(CartController::class)->group(function () {
        Route::post('/carts', 'store')->name('carts.store');
        Route::get('/carts', 'index')->name('carts.index');
        Route::get('/carts/total-cart-items', 'totalCartItems')->name('carts.totalItems');
        Route::post('/carts/increase-qty', 'increase_quantity')->name('carts.increase_quantity');
        Route::post('/carts/decrease-qty', 'decrease_quantity')->name('carts.decrease_quantity');
        Route::delete('/carts/{id}', 'destroy')->name('carts.destroy');


        // order api's
        Route::controller(OrderController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::post('/orders', 'create_order')->name('orders.create_order');
            Route::post('/orders/verify/payment', 'verifyPayment')->name('orders.create_order');
        });
    });

    Route::get('/user-profile', [UserController::class, 'user_profile']);
    Route::prefix('/users')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('/change-password', 'change_password');
        });
    });
});
