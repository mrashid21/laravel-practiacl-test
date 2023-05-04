<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web'])->name('dashboard');

require __DIR__.'/auth.php';

Route::controller(FormController::class)->middleware(['auth:web'])->group(function () {
    Route::get('forms', 'index')->name('form.index');
    Route::post('form', 'store');
    Route::get('form/{id}', 'show');
    Route::put('form/{id}', 'update');
    Route::delete('form/{id}', 'destroy');
    Route::post('attach', 'toggleInputFields');
    Route::get('survey/{form_id}', 'survey')->name('survey.show');
    Route::post('survey', 'submitSurvey')->name('survey.submit');
});
