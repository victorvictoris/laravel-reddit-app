<?php

namespace App\Http\Middleware;

use App\Models\RedditAccessToken;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class EnsureUserIsRegisteredOnReddit
{
    public function handle(Request $request, Closure $next)
    {
        $response = Http::withToken($request->access_token)
            ->get('https://oauth.reddit.com/api/v1/me');

        if (Arr::exists($response, 'name')) {
            $user = User::where('username', $response['name'])->first();
            if ($user) {
                $redditAccessToken = RedditAccessToken::where('user_id', $user->id)->first();
                if ($redditAccessToken->expires_at < Carbon::now()) {
                    return response(['message' => 'Your access token expired.'], 401);
                }
                if (Hash::check($request->access_token, $redditAccessToken->access_token)) {
                    $request->merge(array('user' => $user));
                    return $next($request);
                }
            }
        }

        return response(['message' => 'There is no such an access token'], 404);

    }
}
