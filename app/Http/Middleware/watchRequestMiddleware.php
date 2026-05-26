<?php

namespace App\Http\Middleware;

use App\Models\Api_logs;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
class watchRequestMiddleware
{

    protected $startTime;

    public function handle(Request $request, Closure $next): Response
    {
        $this->startTime = microtime(true);

        return $next($request);
    }


    public function terminate(Request $request, Response $response): void
    {
        try {
            $duration = defined('LARAVEL_START') 
                ? round((microtime(true) - LARAVEL_START) * 1000, 2) 
                : 0;

            $user = auth('sanctum')->user();

            Api_logs::create([
                'user_id'     => $user?->id,
                'type'        => $user ? 'user' : 'guest',
                'endpoint'    => $request->fullUrl(),
                'method'      => $request->method(),
                'duration'    => $duration,
                'status_code' => $response->getStatusCode(), 
            ]);

        } catch (\Throwable $e) {
            Log::error('Failed to log API request: ' . $e->getMessage());
        }
    }
}