<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function indexLogin()
    {
        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $valid_email = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $login = [
            $valid_email => $request->email,
            'password' => $request->password
        ];

        if (Auth()->attempt($login)) {
            // return redirect()->route('show_employee');
            dd($login);
        }
        dd("GAGAL");
        // return redirect()->route('show_login')->with(['error' => 'Email atau Password salah !!!']);
    }
}
