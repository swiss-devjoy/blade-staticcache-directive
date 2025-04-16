<?php

declare(strict_types=1);

namespace SwissDevjoy\BladeStaticcacheDirective;

use Illuminate\Http\Request;

class BladeStaticcacheStatsMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-BladeStaticcache-Cached', (string) app('blade-staticcache')->cachedChunks);
        $response->headers->set('X-BladeStaticcache-Uncached', (string) app('blade-staticcache')->uncachedChunks);

        return $response;
    }
}
