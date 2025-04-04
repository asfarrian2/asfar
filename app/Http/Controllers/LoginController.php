<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    //login admin
    public function admin(){

        return view('auth.log-admin');

    }

    public function admin_proses(Request $request){

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $tahun      = $request->tahun;
            $username   = $request->email;

            $data = [
                'id_tahun' => $tahun
            ];

            DB::table('users')->where('email', $username)->update($data);
            return redirect('/admin/dashboardAll');
        } else {
            return redirect('/ctr_admin')->with(['warning' => 'Username / Password Salah']);
        }

    }

    public function logout(Request $request)
    {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
    }



    //login admin
    public function operator(){

        return view('auth.log-operator');

    }

    public function operator_proses(Request $request){

        if (Auth::guard('operator')->attempt(['username' => $request->email, 'password' => $request->password])) {
            $tahun      = $request->tahun;
            $username   = $request->email;

            $data = [
                'id_tahun' => $tahun
            ];

            DB::table('tb_operator')->where('username', $username)->update($data);

            return redirect('/opt/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'Username / Password Salah']);
        }

    }

}
