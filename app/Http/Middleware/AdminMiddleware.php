<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request,Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        return $request->expectsJson() ? response()->json([
            'status' => 'Unauthorized'
        ], 401) : response('Unauthorized', 401);
    }
}
