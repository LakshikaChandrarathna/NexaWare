<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
