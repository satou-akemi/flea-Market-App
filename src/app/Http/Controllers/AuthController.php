<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view('Auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->only('email','password');

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'ユーザーが存在しません',
            ]);
        }

        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'パスワードが違います',
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'メール認証が完了していません。メールをご確認ください。',
            ]);
        }
        \Illuminate\Support\Facades\Auth::login($user);
        \Log::info('ログインしました：' . Auth::id());

        return redirect('/');
    }

    public function showRegisterForm(){
        return view('Auth.register');
    }

    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();

        //Auth::login($user);

        //このユーザーでログイン状態にする

        return redirect('/setup');
    }

}