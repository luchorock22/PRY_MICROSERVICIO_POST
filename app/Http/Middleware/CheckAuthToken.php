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
        $toke = $request ->bearerToken();
        if (!$toke ) {
            return response()->json(['message' => 'Unauthorized, token invalido'], 401);
        }
        //llamado apirest al microservicio auth para validar token
        $response = Http::withToken($toke)->get('http://192.168.1.18:8000/api/validate-token');
        if ($response->failed()) {
            return response()->json(['message' => 'Unauthorized, token no valido'], 401);
        }
        //guardar datos del usuario en la solicitud
        $request->attributes->add([
            'auth_user' => $response->json('user')
        ]);
        return $next($request);
    }
}
