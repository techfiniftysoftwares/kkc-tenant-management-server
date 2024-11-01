<?php

namespace App\Http\Middleware;

use Closure;

class SetTimeLimit
{
    public function handle($request, Closure $next)
    {
        ini_set('max_execution_time', 180); // Set to 300 seconds (5 minutes)
        // or use: set_time_limit(300);

        return $next($request);
    }
}
