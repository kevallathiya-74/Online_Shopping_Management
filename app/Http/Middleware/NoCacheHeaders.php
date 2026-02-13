<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoCacheHeaders
{
    /**
     * Prevent browser from caching pages.
     *
     * After logout, if user clicks browser Back button,
     * the browser will make a fresh request instead of
     * showing the cached page. The auth middleware will
     * then redirect them to the login page.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Tell the browser: do not cache this page
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
