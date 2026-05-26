<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\watchRequestMiddleware::class);

        $middleware->alias([
                'is_admin' => \App\Http\Middleware\IsAdmin::class,
                'is_writer'     => \App\Http\Middleware\IsWriter::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'error_code' => 'TOO_MANY_REQUESTS',
                    'message' => 'you have exceeded the rate limit, please try again later.',
                    'meta' => [
                        'limit_per_minute' => 60,
                        'retry_after_seconds' => $e->getHeaders()['Retry-After'] ?? 60
                    ]
                ], 429);
            }
        });

        $exceptions->render(function (\Exception $e, $request) {
        
        $statusCode = ($e->getCode() >= 400 && $e->getCode() < 600) ? $e->getCode() : 500;
        
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(), 
            ], $statusCode);
        }
    });

        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'item not found'
        ], 404);

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], $e->getStatusCode());
    });

    });
    })
    ->booting(function () {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
        });
    })
    ->create();
