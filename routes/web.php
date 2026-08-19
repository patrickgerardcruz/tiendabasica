<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;

// 1. Rutas públicas principales
Route::get('/', [ProductController::class, 'index'])->name('productos.index');

// 2. Login / Logout (Ruta protegida y camuflada)
Route::get('/staff', [LoginController::class, 'mostrarLogin'])->name('login');
Route::post('/staff', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/staff/salir', [LoginController::class, 'logout'])->name('logout');

// 3. Rutas protegidas (solo admin autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/productos/nuevo', [ProductController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductController::class, 'edit'])->whereNumber('producto')->name('productos.edit');
    Route::put('/productos/{producto}', [ProductController::class, 'update'])->whereNumber('producto')->name('productos.update');
    Route::delete('/productos/{producto}', [ProductController::class, 'destroy'])->whereNumber('producto')->name('productos.destroy');
});

// 4. Detalle de producto individual (al final para no colisionar con /productos/nuevo)
Route::get('/productos/{producto}', [ProductController::class, 'show'])->whereNumber('producto')->name('productos.show');