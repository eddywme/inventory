<?php

namespace App\Http\Middleware;

use App\Utility\Utils;
use Closure;

class AdminMiddleware
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
        if(!Utils::isAdmin()){
            return redirect('/');
        }
        return $next($request);
    }
}
