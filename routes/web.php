<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// shop
// Route::inertia('/shop', 'Shop/products');
// Route::inertia('/example', 'Example');
// Route::inertia('/detail', 'Shop/product-details');
// Route::inertia('/category', 'Shop/category-show');
// Route::inertia('/cart', 'Shop/cart');
Route::resource('products',ProductController::class);

// travel
Route::inertia('/travel', 'Travel/travel');
Route::resource('posts', PostController::class);
