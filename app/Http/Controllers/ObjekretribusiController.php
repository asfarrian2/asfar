<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ObjekretribusiController extends Controller
{
    public function view(){
        $view = DB::table('tb_ojkretribusi')
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_js', '=', 'tb_ojkretribusi.id_js')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->select('tb_ojkretribusi.*', 'tb_jenretribusi.*', 'tb_subretribusi.*')
        ->get();

        $jenis = DB::table('tb_jenretribusi')
        ->where('status_jr', '1')
        ->get();

        return view('admin.objekretribusi.view', compact('view', 'jenis'));
    }

    public function getobjek($id_jr){
        $sub = DB::table('tb_subretribusi')
        ->where('id_jr', $id_jr)
        ->get();

        return response()->json($sub);
    }

    //Tambah Data
    public function store(Request $request){

        $id_sr=DB::table('tb_ojkretribusi')
        ->latest('id_ojk',   'DESC')
        ->first();

        $kodeobjek ="SR-";

        if($id_sr == null){
            $nomorurut = "00001";
        }else{
            $nomorurut = substr($id_sr->id_sr, 3 , 5) + 1;
            $nomorurut = str_pad($nomorurut, 5, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $kode = $request->kode;
        $nama = $request->nama;
        $jenis= $request->jenis;

        //Validasi Kode Rekening
        $cekkode = DB::table('tb_ojkretribusi')
        ->where('kode_sr', '=', $kode)
        ->count();
         if ($cekkode > 0) {
        return Redirect::back()->with(['warning' => 'Kode Sub Retribusi Sudah Digunakan']);
         }else{

            $data = [
                'id_sr'     => $id,
                'kode_sr'   => $kode,
                'nama_sr'   => $nama,
                'id_jr'     => $jenis,
                'status_sr' =>'1'
            ];

            $simpan = DB::table('tb_ojkretribusi')->insert($data);
            if ($simpan) {
                return Redirect('/admin/subretribusi')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
            }
        }
     }


}
