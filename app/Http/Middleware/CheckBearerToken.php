<?php

namespace App\Http\Middleware;

use Closure;

class CheckBearerToken
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
        if (!$request->bearerToken()) {
            return redirect('/login'); // Redirect to the login page or another route.
        }

        return $next($request);
    }
}
