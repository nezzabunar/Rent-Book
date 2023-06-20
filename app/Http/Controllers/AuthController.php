<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        return view('layouts.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // dd(Auth::user());
            $request->session()->regenerate();
            if(Auth::user()->role_id === 1){
                return redirect('dashboard');
            }

            if(Auth::user()->role_id === 2){
                return redirect('peminjaman');
            }
        }
        Session::flash('status','Failed');
        Session::flash('message','Login Invalid');
        return redirect('/login');
    }

    public function logout(Request $request) {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/login');
    }
}
