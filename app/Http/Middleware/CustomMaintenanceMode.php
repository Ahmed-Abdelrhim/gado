<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('app.maintenance.mode')) {
            session()->put('app.maintenance.mode', 'false');
        }

        if (session('app.maintenance.mode') == 'true') {
            return redirect('app/maintenance');
        }
        return $next($request);
    }
}
