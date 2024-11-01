<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Auth_controller extends Controller
{

    function index() {
        // return Auth::check();
        if (Auth::check()) {
            return redirect('/home');
        }else{
            return view('login');
        }

    }
    function login(Request $data) {

        if (Auth::attempt(['email' => $data->email, 'password' => $data->password, 'role' => $data->role])) {
            return redirect('/home');
        }else{
            session()->flash('eror', 'username/password salah');
            return view('login');
        }
    }

    function home() {
        return view('dashboard.home');
    }

    function logout() {
        Auth::logout();
        return redirect('/'); // Redirect ke halaman login setelah logout
    }
}
