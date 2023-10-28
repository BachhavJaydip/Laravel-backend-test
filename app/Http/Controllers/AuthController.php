<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


class AuthController extends ApiController
{
    protected $client;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->client = DB::table('oauth_clients')
                          ->where(['password_client' => 1])
                          ->first();
    }

    public function authenticate(Request $request)
    {   

        $validator = Validator::make($this->request->all(), [
            'email'  => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            $response['status']     = 'error';
            $response['message']    = 'Please feel all required fields!';
            $response['error_message'] = $validator->errors();
            return response()->json($response);
        }

        $request->request->add([
            'username' => $request->get('email'),
            'password' => $request->get('password'),
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
        ]);
        
        $proxy = Request::create('oauth/token', 'POST');
        
        return Route::dispatch($proxy);
    }

    public function login(Request $request)
    {
        $response['status'] = 401;
        $response['message'] = "Un-authenticated";
        return response()->json($response);
    }
}
