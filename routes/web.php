<?php

use App\Http\Controllers\Equipos\EquiposController;
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
    return view('layouts.inicio');
});

Route::prefix('Equipos')->group(function () {
    Route::get('/Lista', [EquiposController::class, 'index'])->name('viewLista-equipos');

});
