<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole; // 👈 أضفت هذا السطر
use App\Http\Middleware\LanguageMiddleware; // 👈 أضفت هذا السطر

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // أضف هذا المقطع لتسجيل الاسم المستعار 'role'
         $middleware->alias([
        'role' => CheckUserRole::class,
    ]);
        // $middleware->append(\App\Http\Middleware\LanguageMiddleware::class);    })
        $middleware->web(append: [
        LanguageMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
