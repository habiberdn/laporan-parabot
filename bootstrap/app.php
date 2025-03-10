<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, Request $request) {
            if (str_contains($e->getMessage(), 'Attempt to read property "name" on null')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Redirecting due to null property access'
                    ], 302)->header('Location', '/');
                }
                
                return redirect('/');
            }
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
