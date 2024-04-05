<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticateApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');

        if ($apiKey != config('integration.API_KEY')) {
            return api(['error' => 'API key is missing'],401);


        }
        return $next($request);
    }
}
