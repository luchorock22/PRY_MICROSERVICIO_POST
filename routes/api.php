<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS (sin autenticación)
// ============================================
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ============================================
// RUTAS PROTEGIDAS CON MIDDLEWARE auth.micro
// (Valida token contra microservicio de autenticación)
// ============================================
Route::middleware('auth.micro')->group(function () {
    
    // Listar todos los posts
    Route::get('/posts', [PostController::class, 'index']);
    
    // Crear un nuevo post
    Route::post('/posts', [PostController::class, 'store']);
    
    // Ver un post específico por ID
    Route::get('/posts/{post}', [PostController::class, 'show']);
    
    // Actualizar un post
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::patch('/posts/{post}', [PostController::class, 'update']);
    
    // Eliminar un post
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});