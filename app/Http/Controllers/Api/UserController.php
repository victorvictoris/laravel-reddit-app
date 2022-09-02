<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function __construct()
    {
        $this->username = 'victor_victoris3';
        $this->password = 'Poskow333**';
        $this->clientId = 'hetgWZcY_7ijg3V2ff6_FQ';
        $this->clientSecret = 'SH-v9IuufgovStt_-uCZefZn_JXPJw';
    }

    public function show(Request $request)
    {
        $response = Http::withToken($request->access_token)
            ->get('https://oauth.reddit.com/api/v1/me');

        return $response->json();
    }
}
