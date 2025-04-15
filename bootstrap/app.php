<?php
 
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
 
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //render: personalizar la forma en que se gestionan y responden las excepciones
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            //$exceptions es generalmente una instancia del manejador de excepciones de Laravel (Handler)
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Error de autenticacion.',
                    'error' => $e->getMessage()
                ], 401);
            }
        });
    })->create();