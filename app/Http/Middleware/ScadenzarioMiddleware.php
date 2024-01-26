<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ScadenzarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if (is_string($user->groups) && strpos($user->groups, 'GESTIONALE-Scadenzario') !== false) {
                return $next($request);
            }
        }

        return response()->view('Errors.unauthorized', [], 403);
    }
}