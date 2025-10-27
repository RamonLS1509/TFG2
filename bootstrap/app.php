<?php

use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 🔹 Si quieres que corra en todas las peticiones (global):
        // $middleware->append(SomeMiddleware::class);

        // 🔹 Si quieres usarlo con alias (para usar en rutas tipo 'role:admin')
        $middleware->alias([
            'role' => EnsureRole::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();
