<?php

namespace Core\Presentation\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log para verificar se o middleware está sendo invocado
        Log::info('JwtMiddleware invoked');

        // Log do cabeçalho de autorização
        $authorizationHeader = $request->header('Authorization');
        Log::info('Authorization Header: ' . $authorizationHeader);

        try {
            // Autenticar o usuário baseado no token JWT
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error authenticating token: ' . $e->getMessage());
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired'], 401);
            } else {
                return response()->json(['error' => 'Authorization Token not found'], 401);
            }
        }

        // Adiciona o usuário autenticado à requisição
        $request->attributes->set('user', $user);

        return $next($request);
    }
}

