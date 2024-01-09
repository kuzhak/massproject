<?php

use Illuminate\Support\Facades\Route;

Route::post('/user/create', 'App\Http\Controllers\UserController@store');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/requests', 'App\Http\Controllers\RequestController@index');
    Route::put('/requests/{id}', 'App\Http\Controllers\RequestController@update');
    Route::post('/requests', 'App\Http\Controllers\RequestController@store');
});
