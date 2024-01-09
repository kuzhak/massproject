<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/user/create', 'App\Http\Controllers\UserController@store');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/requests', 'App\Http\Controllers\RequestController@index'); //получение заявок ответственным лицом, с фильтрацией по статусу
    Route::put('/requests/{id}', 'App\Http\Controllers\RequestController@update'); //ответ на конкретную задачу ответственным лицом
    Route::post('/requests', 'App\Http\Controllers\RequestController@store'); //отправка заявки пользователями системы
});
