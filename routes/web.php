<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\RegisterStepTwoController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;

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

Route::get('/', function ()
{
    return view('welcome');
});

Route::group(['middleware' => 'auth:sanctum'], function()
{
    Route::group(['middleware' => ['is_register_finished', 'verified']], function ()
    {
        Route::group([
            'prefix' => 'admin',
            'middleware' => 'is_admin',
            'as' => 'admin.'
        ], function ()
        {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('categories', CategoryController::class)->scoped([
                'category' => 'slug'
            ])->except('show');

            Route::resource('products', ProductController::class)->scoped([
                'product' => 'slug'
            ]);

            Route::resource('galleries', ProductGalleryController::class)->only(['store', 'destroy']);

            Route::resource('users', UserController::class)->scoped([
                'user' => 'username'
            ])->only(['index', 'show', 'update', 'destroy']);

            Route::resource('transactions', TransactionController::class)->scoped([
                'transaction' => 'code'
            ])->only('index');

            Route::resource('users.transactions', TransactionController::class)->scoped([
                'user' => 'username',
                'transaction' => 'code'
            ])->only(['show', 'update']);

            Route::put('users/{user:username}/transactions/{transaction:code}', [TransactionController::class, 'updatePayment'])->name('update.payments');
        });

        Route::group([
            'prefix' => 'dashboard',
            'as' => 'dashboard.'
        ], function ()
        {
            Route::get('products', [UserProductController::class, 'index'])->name('products');

            Route::get('products/{product:slug}', [UserProductController::class, 'show'])->name('products.show');

            Route::resource('users.carts', CartController::class)->scoped([
                'user' => 'username'
            ])->only(['index', 'store', 'destroy']);

            Route::resource('users.transactions', UserTransactionController::class)->scoped([
                'user' => 'username',
                'transaction' => 'code'
            ])->only(['index', 'show', 'store']);

            Route::post('shpping.services.get', [RajaOngkirController::class, 'getServices'])->name('shipping.services');
        });

    });

    Route::get('register-steps-two', [RegisterStepTwoController::class, 'create'])->name('register-step-two.create');

    Route::post('register-steps-two', [RegisterStepTwoController::class, 'store'])->name('register-step-two.store');
});
