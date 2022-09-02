<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
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

    public function generateAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password

            ]);

        if ($response->status() == '401') {
            return 'Bad credentials';
        }

        return $response;
    }

    public function show()
    {
        $response = Http::withToken('2203211786872-pKVet7aRiJfshUv19-1JlBrC6rOhkQ')
            ->get('https://oauth.reddit.com/api/v1/me');

        return $response->json();
    }
}
