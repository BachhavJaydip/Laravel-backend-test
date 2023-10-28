<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuthentication
{
    public function handle($request, Closure $next)
    {
        
        if (Auth::guard('api')->check()) {
            return $next($request);
        }

        return response()->json([
                                    "error" =>  "invalid_request", 
                                    "message" => "The access token is invalid.", 
                                    "hint" => "Token has expired"
                                ], 401);
    }
}
