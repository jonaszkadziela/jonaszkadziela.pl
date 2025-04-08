<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$response->headers->has('Cross-Origin-Opener-Policy')) {
            $response->headers->set('Cross-Origin-Opener-Policy', config('security.headers.cross_origin_opener_policy'));
        }

        if (!$response->headers->has('Cross-Origin-Resource-Policy')) {
            $response->headers->set('Cross-Origin-Resource-Policy', config('security.headers.cross_origin_resource_policy'));
        }

        if (!$response->headers->has('Referrer-Policy')) {
            $response->headers->set('Referrer-Policy', config('security.headers.referrer_policy'));
        }

        if (!$response->headers->has('Strict-Transport-Security')) {
            $response->headers->set('Strict-Transport-Security', config('security.headers.strict_transport_security'));
        }

        if (!$response->headers->has('X-Content-Type-Options')) {
            $response->headers->set('X-Content-Type-Options', config('security.headers.x_content_type_options'));
        }

        if (!$response->headers->has('X-Frame-Options')) {
            $response->headers->set('X-Frame-Options', config('security.headers.x_frame_options'));
        }

        if (!$response->headers->has('Permissions-Policy')) {
            $appendString = config('security.headers.permissions_policy_append_string');

            $response->headers->set(
                'Permissions-Policy',
                collect(config('security.headers.permissions_policy'))
                    ->map(fn (array $value, string $key) => $key . '=(' . join(' ', $value) . ')')
                    ->join(', ') . (empty($appendString) ? '' : ', ' . $appendString),
            );
        }

        return $response;
    }
}
