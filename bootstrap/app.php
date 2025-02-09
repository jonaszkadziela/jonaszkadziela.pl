<?php

use App\Http\Middleware\DetermineLanguageFromHeader;
use App\Http\Middleware\DetermineLanguageFromIp;
use App\Http\Middleware\SetLanguage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('telescope:prune --hours=168')->daily();
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
            DetermineLanguageFromHeader::class,
            ThrottleRequests::class . ':api',
        ]);

        $middleware->web([
            DetermineLanguageFromIp::class,
            SetLanguage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
