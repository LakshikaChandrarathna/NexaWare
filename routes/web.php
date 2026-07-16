<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EcomSorderController;
use App\Http\Controllers\EcomsellerController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    return view('products');
});
Route::post('/google-login', [AuthController::class, 'googleLogin']);
Route::post('/custom-register', [AuthController::class, 'register']);
Route::post('/custom-login', [AuthController::class, 'login']);
Route::post('/custom-logout', [AuthController::class, 'logout']);

Route::get('/sellerorders', [EcomSorderController::class, 'index']);
Route::get('/sellerdashboard', [EcomSorderController::class, 'dashboardview']);
Route::post('/seller/company/store', [EcomsellerController::class, 'store']);
Route::get('/sellerprofile', [EcomsellerController::class, 'index']);
Route::put('/seller/company/{id}/update', [EcomsellerController::class, 'update']);
Route::delete('/seller/company/{id}/delete', [EcomsellerController::class, 'destroy']);

Route::group(['as' => 'seller.', 'middleware' => ['auth']], function () {
    Route::get('/sellerprof', [ProfileController::class, 'index'])->name('profile');
});
Route::group(['as' => 'buyer.', 'middleware' => ['auth']], function () {
    Route::get('/buyerprofile', [ProfileController::class, 'buyerprof'])->name('profile');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/submit-profile', [ProfileController::class, 'submitProfile']);


    Route::get('/get-districts/{provinceId}', [ProfileController::class, 'getDistricts']);
    Route::get('/get-gn-divisions/{districtId}', [ProfileController::class, 'getGNDivisions']);
    Route::get('/buyerdashboard',[ProfileController::class, 'dashboarddetails']);
});
Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
