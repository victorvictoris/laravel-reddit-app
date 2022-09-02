<?php

namespace App\Http\Middleware;

use App\Models\RedditAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class EnsureUserIsRegisteredOnReddit
{
    public function handle(Request $request, Closure $next)
    {
        $providedAccessToken = $request->access_token;
        $accessToken = RedditAccessToken::where('access_token', $providedAccessToken)->first();

        if ($accessToken) {
            if ($accessToken->expires_at < Carbon::now()) {
                return response(['message' => 'Your access token expired.'], 401);
            }

            return $next($request);
        } else {
            return response(['message' => 'There is no such an access token'], 404);
        }
    }
}
