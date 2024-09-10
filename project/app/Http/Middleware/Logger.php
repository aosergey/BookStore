<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        Log::info("Start {$startTime}");
        Log::info($request->route()->getName(), request()->all());
        $var = $next($request);
        $endTime = microtime(true);
        Log::info("End {$endTime}");
        $duration = $endTime - $startTime;
        Log::info("Duration {$duration} seconds");
        return $var;
    }
}
