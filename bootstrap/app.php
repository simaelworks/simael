<?php

use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\GuestTeacherMiddleware;
use App\Http\Middleware\StudentAuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/api.php',
            __DIR__.'/../routes/teacher.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'guest' => GuestMiddleware::class,
            'teacher.guest' => GuestTeacherMiddleware::class,
            'student.auth' => StudentAuthMiddleware::class,
            'teacher.auth' => \App\Http\Middleware\TeacherAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
