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
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->rol=='vendedor' || $request->user()->rol == 'admin' ){
            return $next($request);
        }

        throw new \Symfony\Component\HttpKernel\Exception\HttpException(403);
    }
    
}

