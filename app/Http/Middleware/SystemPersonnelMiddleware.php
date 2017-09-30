<?php

namespace App\Http\Middleware;

use App\Utility\RoleUtils;
use Closure;

class SystemPersonnelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!RoleUtils::isSystemPersonnel()) {
            return redirect('/');
        }
        return $next($request);
    }
}
