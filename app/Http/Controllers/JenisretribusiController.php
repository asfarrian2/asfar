<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class JenisretribusiController extends Controller
{
    //Tampilkan Data
    public function view(){
        $view = DB::table('tb_jenretribusi')
        ->get();

        return view('admin.jenisretribusi.view', compact('view'));
    }

    //Tambah Data
    public function store(Request $request){

        $id_jr=DB::table('tb_jenretribusi')
        ->latest('id_jr',   'DESC')
        ->first();

        $kodeobjek ="JR-";

        if($id_jr == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_jr->id_jr, 3 , 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $kode_jr = $request->kode_jr;
        $nama_jr = $request->nama_jr;

        $data = [
            'id_jr'     => $id,
            'kode_jr'   => $kode_jr,
            'nama_jr'   => $nama_jr,
            'status_jr' =>'0'
        ];

        $simpan = DB::table('tb_jenretribusi')->insert($data);
        if ($simpan) {
            return Redirect('/admin/jenisretribusi')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }

     //Hapus Data
     public function delate($id_jr)
     {
        $id = Crypt::decrypt($id_jr);

        $delete = DB::table('tb_jenretribusi')->where('id_jr', $id)->delete();
        if ($delete) {
            return redirect('/admin/jenisretribusi')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
     }



}
