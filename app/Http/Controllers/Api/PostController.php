<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            // Obtener el usuario del token desde el middleware
            $userId = $request->attributes->get('auth_user')['id'];

            // Crear el post con el user_id
            $post = Post::create(array_merge(
                $validated,
                ['user_id' => $userId]
            ));

            return response()->json([
                'message' => 'Post creado correctamente',
                'post' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            $post->load('user');
            return response()->json($post, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        try {
            // Obtener el usuario del token
            $userId = $request->attributes->get('auth_user')['id'];

            // Verificar que el usuario sea propietario o admin
            if ($post->user_id !== $userId && $request->attributes->get('auth_user')['role'] !== 'admin') {
                return response()->json([
                    'message' => 'No tienes permiso para actualizar este post'
                ], 403);
            }

            // Actualizar el post
            $post->update($validated);

            return response()->json([
                'message' => 'Post actualizado correctamente',
                'post' => $post
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Request $request)
    {
        try {
            // Obtener el usuario del token
            $userId = $request->attributes->get('auth_user')['id'];

            // Verificar que el usuario sea propietario o admin
            if ($post->user_id !== $userId && $request->attributes->get('auth_user')['role'] !== 'admin') {
                return response()->json([
                    'message' => 'No tienes permiso para eliminar este post'
                ], 403);
            }

            // Eliminar el post
            $post->delete();

            return response()->json([
                'message' => 'Post eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}