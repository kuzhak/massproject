<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Models\Request;

Route::post('/user/create', [UserController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/requests', [RequestController::class, 'index'])->can('view', Request::class);
    Route::put('/requests/{id}', [RequestController::class, 'update'])->can('update', Request::class);
    Route::post('/requests', [RequestController::class, 'store'])->can('create', Request::class);
});
