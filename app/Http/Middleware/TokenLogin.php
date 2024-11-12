<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class TokenLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the request has a token
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Remove 'Bearer ' if the token has it
        $token = str_replace('Bearer ', '', $token);

        // Find the user by token
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Log the user in
        auth()->login($user);

        return $next($request);
    }
}
