<?php

// routes/api.php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartAjaxController;



//register and login route controller

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// مسار لتسجيل الدخول
Route::post('/login', [RegisteredUserController::class, 'login']);


// مسار لتسجيل المستخدمين الجدد
Route::post('/register', [RegisteredUserController::class, 'store']);

// routes/api.php
Route::middleware('auth:sanctum')->post('/cart', [CartAjaxController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart', [CartAjaxController::class, 'store'])->name('api.cart.store');
    Route::get('/cart', [CartAjaxController::class, 'index'])->name('api.cart.index');
    Route::put('/cart/{id}', [CartAjaxController::class, 'update'])->name('api.cart.update');
    Route::delete('/cart/{id}', [CartAjaxController::class, 'destroy'])->name('api.cart.destroy');
});


//Route::get('/test', function () {
//    return response()->json(['message' => 'API is working']);
//});
//
//Route::get('/ping', function () {
//    return response()->json(['status' => 'OK']);
//});
