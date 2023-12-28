<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgetPasswordManager;
use App\Http\Controllers\ProductController;
use Illuminate\Auth\Events\Login;
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

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return "Hi";
    });
});
Route::get('/forgetpassword', [ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
Route::post('/forgetpassword', [ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');

//Product
Route::get('/get_products_index', [ProductController::class, 'index'])->name('products.index');
Route::get('/get_products_create', [ProductController::class, 'create'])->name('products.create');
Route::post('/post_products_store', [ProductController::class, 'store'])->name('products.store');
Route::get('/get_products/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/get_products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/get_products/{product}', [ProductController::class, 'update'])->name('product.update');
Route::get('/get_products/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

//Category
Route::get('/get_categories_index', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/get_categories_create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/post_categories_store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/get_categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/get_categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/get_categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/get_categoriescts/{categoryChild}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

//Brand
Route::get('/get_brands_index', [BrandController::class, 'index'])->name('brand.index');
Route::get('/get_brands_create', [BrandController::class, 'create'])->name('brand.create');
Route::post('/post_brands_store', [BrandController::class, 'store'])->name('brand.store');
Route::get('/get_brands/{product}', [BrandController::class, 'show'])->name('brand.show');
Route::get('/get_brands/{product}/edit', [BrandController::class, 'edit'])->name('brand.edit');
Route::put('/get_brands/{product}', [BrandController::class, 'update'])->name('brand.update');
Route::get('/get_brands/{product}/delete', [BrandController::class, 'destroy'])->name('brand.destroy');