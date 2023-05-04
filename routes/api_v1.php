<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(TodoController::class)->group(function () {
    Route::get('todos', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
});

Route::controller(FormController::class)->group(function () {
    Route::get('forms', 'index');
    Route::post('form', 'store');
    Route::get('form/{id}', 'show');
    Route::put('form/{id}', 'update');
    Route::delete('form/{id}', 'destroy');
    Route::post('attach', 'toggleInputFields');
});

Route::controller(InputController::class)->group(function () {
    Route::get('inputs', 'index');
    Route::post('input', 'store');
    Route::get('input/{id}', 'show');
    Route::put('input/{id}', 'update');
    Route::delete('input/{id}', 'destroy');
});