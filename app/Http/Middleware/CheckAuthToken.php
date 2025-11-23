<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el token del header Authorization: Bearer {token}
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['message' => 'Unauthorized, token inválido'], 401);
        }

        try {
            // Obtener la URL del microservicio de autenticación desde .env
            $authServiceUrl = config('services.auth.url') ?? env('AUTH_SERVICE_URL', 'http://localhost:8001');
            
            // Realizar llamada HTTP al microservicio de autenticación para validar el token
            $response = Http::withToken($token)
                ->timeout(5)  // Agregar timeout de 5 segundos
                ->get($authServiceUrl . '/api/validate-token');

            if ($response->failed()) {
                return response()->json(['message' => 'Unauthorized, token no válido'], 401);
            }

            // Guardar datos del usuario en los atributos de la solicitud
            $request->attributes->add([
                'auth_user' => $response->json('user')
            ]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al validar el token',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}