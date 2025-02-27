<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function view(){
        $view = DB::table('tb_operator')
        ->leftJoin('tb_agency', 'tb_operator.id_agency', '=', 'tb_agency.id_agency')
        ->select('tb_operator.*', 'tb_agency.nama_agency')
        ->get();

        $skpd = DB::table('tb_agency')
        ->get();

        return view('admin.operator.view', compact('view', 'skpd'));
    }

    public function store(Request $request){

        $id_operator=DB::table('tb_operator')
        ->latest('id_operator', 'DESC')
        ->first();

        $kodeobjek ="OP-";

        if($id_operator == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_operator->id_operator, 3, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $username       = $request->username;
        $password       = Hash::make($username);
        $id_agency      = $request->id_agency;

        $data = [
            'id_operator'   => $id,
            'username'      => $username,
            'password'      => $password,
            'id_agency'     => $id_agency
        ];

        $simpan = DB::table('tb_operator')->insert($data);
        if ($simpan) {
            return Redirect('/admin/operator')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }

    //Tampilkan Halaman Edit Data
    public function edit(Request $request){

        $id_operator    = $request->id_operator;
        $id_operator    = Crypt::decrypt($id_operator);

        $tb_operator    = DB::table('tb_operator')
                        ->where('id_operator', $id_operator)
                        ->first();

        $tb_agency    = DB::table('tb_agency')
                        ->get();

        return view('admin.operator.edit', compact('id_operator', 'tb_agency', 'tb_operator'));
    }

    //Update Data
    public function update($id_operator, Request $request){

        $id_operator    = Crypt::decrypt($id_operator);
        $username       = $request->username;
        $id_agency      = $request->id_agency;

        $data = [
            'username'      => $username,
            'id_agency'     => $id_agency
        ];

        $update = DB::table('tb_operator')->where('id_operator', $id_operator)->update($data);
        if ($update) {
            return Redirect('/admin/operator')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
     }

     //Reset Password
     public function reset($id_operator){

        $id_operator    = Crypt::decrypt($id_operator);
        $tb_operator    = DB::table('tb_operator')->where('id_operator', $id_operator)->first();
        $username       = $tb_operator->username;

        $data = [
            'password'      => Hash::make($username)
        ];

        $update = DB::table('tb_operator')->where('id_operator', $id_operator)->update($data);
        if ($update) {
            return Redirect('/admin/operator')->with(['success' => 'Password Akun Berhasil Direset']);
        } else {
            return Redirect::back()->with(['warning' => 'Password Akun Gagal Direset']);
        }
     }

     //Hapus Akun
     public function delate($id_operator){

        $id_operator    = Crypt::decrypt($id_operator);

        $delete = DB::table('tb_operator')->where('id_operator', $id_operator)->delete();
        if ($delete) {
            return Redirect('/admin/operator')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
     }


}
