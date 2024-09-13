<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Symfony\Component\Translation\t;

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
                if (JWTAuth::check()) {
                    return $next($request);
                }
                else{
                    return redirect()->route('login');
                }
            }
        } catch (JWTException $e) {
            try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user){
                return $next($request);
            }
            else{
                return redirect()->route('login');
            }
            }
            catch (JWTException $e) {
                return redirect()->route('login');
            }
        }
    }
}
