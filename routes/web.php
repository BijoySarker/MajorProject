<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
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
Route::get('/product', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

//Category
Route::get('/category', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/category/{categoryChild}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/parent', [CategoryController::class, 'parentCategories'])->name('categories.parent');
Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');

//Brand
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
Route::post('/brand//store', [BrandController::class, 'store'])->name('brand.store');
Route::get('/brand/{brand}/edit', [BrandController::class, 'edit'])->name('brand.edit');
Route::put('/brand/{brand}', [BrandController::class, 'update'])->name('brand.update');
Route::get('/brand/{brand}/delete', [BrandController::class, 'destroy'])->name('brand.destroy');

//Customer
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/{customer}', [CustomerController::class, 'show'])->name('customer.show');
Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
Route::get('/customer/{customer}/delete', [CustomerController::class, 'destroy'])->name('customer.destroy');