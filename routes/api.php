<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Todas las rutas del microservicio de Posts protegidas con auth.micro
Route::middleware('auth.micro')->group(function () {

    Route::get('/posts', [PostController::class, 'index']);      // Listar posts
    Route::get('/posts/{id}', [PostController::class, 'show']); // Ver un post
    Route::post('/posts', [PostController::class, 'store']);    // Crear post
    Route::put('/posts/{id}', [PostController::class, 'update']); // Actualizar
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Eliminar

});
