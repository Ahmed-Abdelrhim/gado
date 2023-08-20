<?php

namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CustomMaintenanceMode extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
         if (env('CUSTOM_APP_MAINTENANCE')) {
            return $next($request);
        }
        return redirect('app/maintenance');
    }
}