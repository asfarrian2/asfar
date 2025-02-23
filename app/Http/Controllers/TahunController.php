<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TahunController extends Controller
{
    public function view(){
        $view = DB::table('tb_tahun')
        ->get();

        return view('admin.tahun.view', compact('view'));
    }

    public function store(Request $request){

        $id_tahun=DB::table('tb_tahun')
        ->latest('id_tahun',   'DESC')
        ->first();

        $kodeobjek ="TA-";

        if($id_tahun == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_tahun->id_tahun, 3 , 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $tahun       = $request->tahun;
        $keterangan  = $request->keterangan;

        $data = [
            'id_tahun'      => $id,
            'tahun_ta'      => $tahun,
            'keterangan_ta' => $keterangan,
            'status_ta'     =>'nonaktif'
        ];

        $simpan = DB::table('tb_tahun')->insert($data);
        if ($simpan) {
            return Redirect('/admin/ta')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }


}
