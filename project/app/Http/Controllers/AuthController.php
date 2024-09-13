<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
//            'remember' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // I don't know how to handle this
        if (!$token = JWTAuth::attempt($credentials)) {
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

    public function forgotPassword(){
        return view('auth.forgotPassword');
    }

    public function sendResetEmail(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }


    public function resetPassword($token){
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(){
        return redirect('login');
    }

    public function endSession(Request $request){
        try {
            //Handling requests with header in request
            $token = $request->bearerToken();
            $forever = true;
            JWTAuth::parseToken()->invalidate($forever);
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
        event(new Registered($user));

        return redirect("login")->with('success', 'You are registered successfully');

    }

    public function dashboard(){
        return view('dashboard');
    }


}
