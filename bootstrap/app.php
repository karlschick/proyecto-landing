<?php

use App\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'      => \App\Http\Middleware\IsAdmin::class,
            'editor'     => \App\Http\Middleware\IsEditor::class,
            'researcher' => \App\Http\Middleware\IsResearcher::class,
            'columnist'  => \App\Http\Middleware\IsColumnist::class,
            'seller'     => \App\Http\Middleware\IsSeller::class,
            'customer'   => \App\Http\Middleware\IsCustomer::class,
            'user'       => \App\Http\Middleware\IsUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
