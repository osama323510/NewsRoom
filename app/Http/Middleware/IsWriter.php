<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsWriter
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role =='writer' ) {
                return $next($request);
            }

            
            if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be a writer to access this page.',
                'code' => 'UNVERIFIED_FREELANCER' 
            ], 403);
        }
    }
}
