<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateLastUsedAt
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if ($request->user()) {
                $token = $request->user()->currentAccessToken();

                Log::info('User Token:', ['token' => $token]);

                if ($token) {
                    $token->last_used_at = now();
                    $token->save();
                } else {
                    Log::warning('No current access token found for user.');
                }
            } else {
                Log::warning('No authenticated user found.');
            }
        } catch (\Exception $e) {
            Log::error('Error in UpdateLastUsedAt Middleware', ['exception' => $e]);
        }

        return $next($request);
    }
}
