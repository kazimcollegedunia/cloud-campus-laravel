<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = $request->user();

        // No user → token missing or invalid
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token. Please login again.'
            ], 401);
        }

        // Token expired?
        // bearerToken
        $token = $user->token();
        if (!$token || $token->revoked) {
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please login again.'
            ], 401);
        }

        // return $next($request);
        return $next($request);
    }
}
