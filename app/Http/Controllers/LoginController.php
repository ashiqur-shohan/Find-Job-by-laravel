<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // @desc Show login form
    // @route GET / login
    public function login( ){
        return view("auth.login");
    }

    // @desc Authenticate user 
    // @route POST /login
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email'=> 'required|string|email|max:100',
            'password'=> 'required|string',
        ]);

        // Attempt to authenticate user
        if(Auth::attempt($credentials)){
            //regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success','You are now logged in!');
        }

        //If auth fails, redirect back with error
        return back()->withErrors([
            'email'=> 'The provided credentials do not match out records'
        ])->onlyInput('email');
    }
}
