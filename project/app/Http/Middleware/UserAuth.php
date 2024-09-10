<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('jwt_token');
        try {
            if (!$user = JWTAuth::setToken($token)->authenticate()) {
                return redirect()->route('login');
            }
            else{
                return $next($request);
            }
        } catch (JWTException $e) {
            try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user){
                return $next($request);
            }
            else{
                return response()->json(['error' => 'User not found'], 404);
            }
            }
            catch (JWTException $e) {
                return response()->json(['error' => 'Token is invalid or expired'], 401);
            }
        }
    }
}
