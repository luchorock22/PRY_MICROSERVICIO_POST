
<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Ruta de prueba del usuario (opcional)
Route::get('/user', function (Request $request) {
    return $request->user();

})->middleware('auth:sanctum');

    Route::get('/posts', [PostController::class, 'index'])->middleware('auth.micro');    // Listar posts
    Route::get('/posts/{id}', [PostController::class, 'show']);  // Ver un post
    Route::post('/posts', [PostController::class, 'store']);     // Crear post
    Route::put('/posts/{id}', [PostController::class, 'update']); // Actualizar post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Eliminar post
