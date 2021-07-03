<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryItemController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\RentController;
use Illuminate\Support\Facades\Route;



// Route Non Logged In
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Route Group Module : Category
Route::prefix('category')->group(function () {
    Route::get('/', [CategoryItemController::class, 'get_all']);
    Route::get('/get/{id}', [CategoryItemController::class, 'get']);
    Route::post('/delete/{id}', [CategoryItemController::class, 'delete']);
    Route::post('/store', [CategoryItemController::class, 'store']);
    Route::post('/update/{id}', [CategoryItemController::class, 'update']);
});

// Route Group Module : Item
Route::prefix('item')->group(function () {
    Route::get('/', [ItemController::class, 'get_all']);
    Route::get('/new', [ItemController::class, 'get_new']);
    Route::get('/populer', [ItemController::class, 'get_populer']);
    Route::get('/get/{id}', [ItemController::class, 'get']);
    Route::post('/delete/{id}', [ItemController::class, 'delete']);
    Route::post('/store', [ItemController::class, 'store']);
    Route::post('/search', [ItemController::class, 'search']);
    Route::post('/update/{id}', [ItemController::class, 'update']);
});

// Route Group Module : Rent
Route::prefix('rent')->group(function () {
    Route::post('/add', [RentController::class, 'add_rent']);
    Route::get('/get/{id}', [RentController::class, 'get_rent']);
    Route::get('/booked/{id}', [RentController::class, 'get_rent_booked']);
    Route::get('/waiting/{id}', [RentController::class, 'get_rent_waiting']);
    Route::get('/lunas/{id}', [RentController::class, 'get_rent_lunas']);
    Route::get('/dipinjam/{id}', [RentController::class, 'get_rent_dipinjam']);
    Route::get('/selesai/{id}', [RentController::class, 'get_rent_selesai']);
    Route::get('/update_status/{id}', [RentController::class, 'update_rent_payment_status']);
    Route::get('/update_return/{id}', [RentController::class, 'update_rent_return_date']);
    Route::post('/update_file/{id}', [RentController::class, 'update_rent_payment_file']);
});
