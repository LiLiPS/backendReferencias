<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @param $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        try {
            //Access token from the request
            $token = JWTAuth::parseToken();
            //Try authenticating user
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->unauthorized('Tu sesión ha expirado. Por favor, inicia sesión de nuevo.');
        } catch (TokenInvalidException $e) {
            return $this->unauthorized('Tu sesión es inválida. Por favor, inicia sesión de nuevo.');
        } catch (JWTException $e) {
            return $this->unauthorized('Por favor, adjunta un Bearer Token a tu petición.');
        }

        //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if ($user && in_array($user->rol_id, [$roles])) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    private function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'No tienes autorización de acceder a este recurso.',
            'success' => false
        ], 401);
    }
}
