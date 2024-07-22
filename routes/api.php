<?php

use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

//Route::get('goods', [ProductController::class, 'index']);
//Route::get('goods/{id}', [ProductController::class, 'show']);

Route::prefix('v1')->group(function () {
    Route::get('goods', [ProductController::class, 'index']);
    Route::get('goods/{id}', [ProductController::class, 'show']);
});
