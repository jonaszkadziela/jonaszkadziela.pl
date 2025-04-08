<?php

use App\Http\Middleware\DetermineLanguageFromHeader;
use App\Http\Middleware\DetermineLanguageFromIp;
use App\Http\Middleware\SetLanguage;
use App\Http\Middleware\SetSecurityHeaders;
use App\Policies\ApiPolicy;
use App\Policies\WebPolicy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Spatie\Csp\AddCspHeaders;

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
            AddCspHeaders::class . ':' . ApiPolicy::class,
            SetSecurityHeaders::class,
            DetermineLanguageFromHeader::class,
            ThrottleRequests::class . ':api',
        ]);

        $middleware->web([
            AddCspHeaders::class . ':' . WebPolicy::class,
            SetSecurityHeaders::class,
            DetermineLanguageFromIp::class,
            SetLanguage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
