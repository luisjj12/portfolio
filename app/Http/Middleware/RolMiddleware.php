<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        $usuario = $request->user();

        // El admin puede hacer todo lo que puede hacer un vendedor, así que
        // siempre le dejamos pasar independientemente de qué rol pida la ruta.
        if ($usuario->rol === 'admin') {
            return $next($request);
        }

        if ($usuario->rol === $rol) {
            return $next($request);
        }

        throw new \Symfony\Component\HttpKernel\Exception\HttpException(403);
    }
    
}

