<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action

        return $this->logActivity($request, $response);
    }

    /**
     * @param Request $request
     * @param         $response
     *
     * @return mixed
     */
    public function logActivity(Request $request, $response)
    {
        Log::debug('I/O', [
            'URL' => $request->fullUrl(),
            'Method' => $request->method(),
            'IP Address' => $request->ip(),
            'Request' => $request->getContent(),
            'Response' => $response->getContent(),
        ]);

        return $response;
    }
}
