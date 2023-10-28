<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (Auth::guard('api')->check() == true) {
            $user = Auth::guard('api')->user();
            return $user;
        }
        else{


            return response()->json([
                "error" =>  "invalid_request", 
                "message" => "The access token is invalid.", 
                "hint" => "Token has expired"
            ], 401);




            return $request->expectsJson()
            ? response()->json(["error" =>  "invalid_request", 
                                "message" => "The access token is invalid.", 
                                "hint" => "Token has expired"
                                ], 401)
            : route('login');
     
            return route('login');
        }
    }
}
