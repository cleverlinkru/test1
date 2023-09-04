<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'patient', 'as' => 'patient'], function () {
    Route::get('', [\App\Http\Controllers\PatientController::class, 'index'])->name('index');
    Route::post('create', [\App\Http\Controllers\PatientController::class, 'create'])->name('create');
});
