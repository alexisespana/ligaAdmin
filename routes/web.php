<?php

use App\Http\Controllers\Categorias\CategoriasController;
use App\Http\Controllers\Equipos\EquiposController;
use App\Http\Controllers\Grupos\GruposController;
use App\Http\Controllers\Jornadas\JornadasController;
use App\Http\Controllers\Juegos\JuegosController;
use App\Http\Controllers\Resultados\ResultadosController;
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

Route::prefix('Categorias')->group(function () {
    Route::get('/Lista', [CategoriasController::class, 'index'])->name('viewLista-categorias');
    Route::post('/datatables', [CategoriasController::class, 'datatableCategorias'])->name('datatables-categorias');
    Route::get('/viewCrearCategorias', [CategoriasController::class, 'viewCrearCategorias'])->name('view-agregar-categorias');
    Route::post('/agregar', [CategoriasController::class, 'agregarCategorias'])->name('agregar-categorias');
    Route::post('/viewEditar', [CategoriasController::class, 'viewEditarCategorias'])->name('view-editar-categoria');
    Route::post('/editar', [CategoriasController::class, 'EditarCategorias'])->name('editar-categorias');
    Route::post('/delete', [CategoriasController::class, 'deleteCategorias'])->name('eliminar-categorias');
});
Route::prefix('Grupos')->group(function () {
    Route::get('/Lista', [GruposController::class, 'index'])->name('viewLista-grupos');
    Route::post('/viewCrearGrupos', [GruposController::class, 'viewCrearCrupos'])->name('view-agregar-grupos');
    Route::post('/agregar', [GruposController::class, 'agregarGrupos'])->name('agregar-grupos');
});

Route::prefix('Resultados')->group(function () {
    Route::get('/Lista', [ResultadosController::class, 'index'])->name('viewLista-resultados');
});

Route::prefix('Equipos')->group(function () {
    Route::get('/Lista', [EquiposController::class, 'index'])->name('viewLista-equipos');
    Route::post('/datatables', [EquiposController::class, 'datatableEquipos'])->name('datatables-equipos');
    Route::get('/viewCrearEquipos', [EquiposController::class, 'viewCrearEquipos'])->name('view-agregar-equipos');
    Route::post('/agregar', [EquiposController::class, 'agregarEquipos'])->name('agregar-equipo');
    Route::post('/viewEditar', [EquiposController::class, 'viewEditarEquipo'])->name('view-editar-equipo');
    Route::post('/editar', [EquiposController::class, 'Editarequipo'])->name('editar-equipo');
});
Route::prefix('Juegos')->group(function () {
    Route::get('/Lista', [JuegosController::class, 'index'])->name('viewLista-juegos');
});
Route::prefix('Jornadas')->group(function () {
    Route::get('/Lista', [JornadasController::class, 'index'])->name('viewLista-jornadas');
    Route::post('/Crear', [JornadasController::class, 'viewCrearJornadas'])->name('view-crear-jornada');
    Route::post('/Modificar', [JornadasController::class, 'modificarJornada'])->name('modificar-jornada');
});
