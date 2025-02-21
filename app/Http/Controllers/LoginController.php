<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    //login admin
    public function admin(){

        return view('auth.log-admin');

    }

    public function admin_proses(Request $request){

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboardAll');
        } else {
            return redirect('/')->with(['warning' => 'Username / Password Salah']);
        }

    }


}
