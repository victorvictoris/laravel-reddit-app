<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\RedditAccessToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $response = Http::withBasicAuth($request->clientId, $request->clientSecret)
            ->asForm()
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'password',
                'username' => $request->username,
                'password' => $request->password

            ]);

        if (Arr::exists($response, 'error') && $response['error'] == 'invalid_grant') {
            return response()->json('Username or Password that you provided are wrong.', 400);
        }

        if ($response->status() == '401') {
            return response()->json('You provided bad credentials.', $response->status());
        }

        $access_token = $response['access_token'];

        $redditAccessToken = RedditAccessToken::create([
            'access_token' => $access_token,
            'expires_at' => Carbon::now()->addSeconds($response['expires_in']),
        ]);

        return response()
            ->json([
                'token' => $access_token,
                'message' => 'You successfully logged in. Your token will expire at: '. $redditAccessToken->expires_at],
                $response->status());
    }
}
