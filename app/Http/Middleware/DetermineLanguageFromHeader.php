<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DetermineLanguageFromHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('X-Language')) {
            return $next($request);
        }

        App::setLocale($request->header('X-Language'));

        return $next($request);
    }
}
