<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\DisputaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;

Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');
Route::post('/registro', [AuthController::class, 'register'])->name('registro.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/libros/{libro}', [LibroController::class, 'show'])
    ->name('libros.show');

Route::get('/perfil', [PerfilController::class, 'index'])
    ->middleware('auth')
    ->name('perfil');

Route::get('/publicar', [LibroController::class, 'create'])
    ->middleware('auth')
    ->name('libros.create');

Route::post('/libros', [LibroController::class, 'store'])
    ->middleware('auth')
    ->name('libros.store');

Route::get('/mis-libros/{libro}', [LibroController::class, 'showOwner'])
    ->middleware('auth')
    ->name('libros.owner');

Route::delete('/libros/{libro}', [LibroController::class, 'destroy'])
    ->middleware('auth')
    ->name('libros.destroy');

Route::post('/solicitudes', [SolicitudController::class, 'store'])
    ->middleware('auth')
    ->name('solicitudes.store');

Route::patch('/solicitudes/{solicitud}', [SolicitudController::class, 'update'])
    ->middleware('auth')
    ->name('solicitudes.update');

Route::post('/disputas', [DisputaController::class, 'store'])
    ->middleware('auth')
    ->name('disputas.store');

Route::get('/admin/disputas', [DisputaController::class, 'index'])
    ->middleware('auth')
    ->name('admin.disputas');

Route::patch('/admin/disputas/{disputa}/resolver', [DisputaController::class, 'resolve'])
    ->middleware('auth')
    ->name('admin.disputas.resolve');

Route::get('/admin/categorias', [CategoriaController::class, 'index'])
    ->middleware('auth')
    ->name('admin.categorias');

Route::post('/admin/categorias', [CategoriaController::class, 'store'])
    ->middleware('auth')
    ->name('admin.categorias.store');

Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.categorias.destroy');

Route::get('/contacto', [ContactoController::class, 'index'])
    ->name('contacto');

Route::post('/contacto', [ContactoController::class, 'store'])
    ->name('contacto.store');