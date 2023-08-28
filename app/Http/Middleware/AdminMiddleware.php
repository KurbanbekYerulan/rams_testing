<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->roles->contains('name', 'admin')) {
            return $next($request);
        }

        return response()->json(['error' => 'Only admins are allowed.'], 403);
    }
}

