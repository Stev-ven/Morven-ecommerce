<?php

use App\Models\ProductCards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCardsController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/add-productcard', [ProductCardsController::class,'addProdcutCard']);
Route::post('/add-image-group', [ProductCardsController::class,'addImageGroup']);
Route::post('/add-product', [ProductCardsController::class,'addProduct']);
Route::post('add-collection', [ProductCardsController::class, 'addCollection']);