<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
        }


    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            return redirect()->route('login');
        }
        session([
            'jwt_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);

        return redirect()->route('dashboard')->with([
                'success' => 'Signed in',
        ]);
    }

    public function logout(){
        return redirect('login');
    }

    public function endSession(Request $request){
        try {
            //Handling requests with header in request
            $token = $request->bearerToken();
            Auth::logout();
            JWTAuth::setToken($token);
            JWTAuth::invalidate($token);
            session()->flush();
            return redirect('login');
        }
        catch (\Exception $e) {
            $token = session('jwt_token');
            JWTAuth::setToken($token);
            JWTAuth::invalidate($token);
            $request->session()->invalidate();
            $request->session()->flush();
            return redirect('login');
        }

    }

    public function register(){
        return view('auth.register');
    }

    public function storeUser(Request $request){
        $validator =  $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = $this->authService->create($validator);

        return redirect("login")->with('success', 'You are registered successfully');

    }

    public function dashboard(){
        return view('dashboard');
    }


}
