<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FoodItemController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/admin/login');
});


Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('admin.admin-login');
    });

    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout');
    });

    Route::middleware('auth')->group(function () {
        // dashboard
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard.index');
            Route::get('/monthly-orders',  'monthly_orders');
        });


        // category routes
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category',  'show_categories')->name('category.show_categories');
            Route::delete('/category/{id}',  'destroy')->name('category.destroy');
            Route::get('/category/{category}/edit',  'edit')->name('category.edit');
            Route::put('/category/{category}/update',  'update')->name('category.update');
            Route::view('/add-category', 'admin.category.add-category');
            Route::post('/add-category',  'addCategory')->name('category.add');
        });

        // foot items routes
        Route::controller(FoodItemController::class)->group(function () {
            Route::get('/foods', 'show_food_items');
            Route::delete('/foods/{id}', 'destroy')->name('foods.destroy');
            Route::patch('/foods/{food_item}/status',  'update_status')->name('foods.updateStatus');
            Route::get('/food/{food}/update', 'show')->name('food-item.show');
            Route::put('/food/{food}/update', 'update')->name('food-item.update');
            Route::get('/add-food',  'addFoodItem')->name('foods.add');
            Route::post('/add-food',  'storeFoodItem')->name('foods.store');
        });

        // order routes
        Route::controller(OrderController::class)->group(function () {
            Route::get('/orders', 'index');
            Route::patch('/orders/{order}/status', 'update_status')->name('orders.updateStatus');
        });

        // slider routes
        Route::controller(SliderController::class)->group(function () {
            Route::get('/sliders', 'index')->name('sliders.index');
            Route::view('/add-slider', 'admin.slider.add-new-slider');
            Route::post('/sliders', 'store')->name('sliders.store');
            Route::get('/slider/{slider}/edit', 'edit')->name('slider.edit');
            Route::put('/slider/{slider}/update', 'update')->name('slider.update');
            Route::patch('/sliders/{slider}/status', 'update_status')->name('sliders.updateStatus');
            Route::delete('/slider/{slider}', 'destroy')->name('slider.destroy');
        });

        // user routes 
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index');
            Route::prefix('users')->group(function () {
                Route::patch('/update-status/{user}', 'update_status')->name('users.update_status');
            });
        });
    });
});
