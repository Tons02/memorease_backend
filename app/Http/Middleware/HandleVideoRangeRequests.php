<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HandleVideoRangeRequests
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof BinaryFileResponse) {
            $response->headers->set('Accept-Ranges', 'bytes');
        }

        return $response;
    }
}
