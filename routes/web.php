<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
