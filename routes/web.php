<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tariffs', TariffController::class);
Route::resource('orders', OrderController::class);

Route::post('test-order-validation', [OrderController::class, 'testValidation']);

