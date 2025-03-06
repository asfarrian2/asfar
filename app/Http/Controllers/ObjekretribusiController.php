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
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->select('tb_ojkretribusi.*', 'tb_jenretribusi.nama_jr', 'tb_subretribusi.kode_sr', 'tb_subretribusi.nama_sr')
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

        $id_ojk=DB::table('tb_ojkretribusi')
        ->latest('id_ojk',   'DESC')
        ->first();

        $kodeobjek ="oj-";

        if($id_ojk == null){
            $nomorurut = "000001";
        }else{
            $nomorurut = substr($id_ojk->id_ojk, 3 , 6) + 1;
            $nomorurut = str_pad($nomorurut, 6, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $kode = $request->kode;
        $nama = $request->nama;
        $sub  = $request->sub;

        //Validasi Kode Rekening
        $cekkode = DB::table('tb_ojkretribusi')
        ->where('kode_ojk', '=', $kode)
        ->count();
         if ($cekkode > 0) {
        return Redirect::back()->with(['warning' => 'Kode Sub Retribusi Sudah Digunakan']);
         }else{

            $data = [
                'id_ojk'     => $id,
                'kode_ojk'   => $kode,
                'nama_ojk'   => $nama,
                'id_sr'     => $sub,
                'status_ojk' =>'1'
            ];

            $simpan = DB::table('tb_ojkretribusi')->insert($data);
            if ($simpan) {
                return Redirect('/admin/objekretribusi')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
            }
        }
     }


    //Tampilkan Halaman Edit Data
    public function edit(Request $request){

        $id_ojk    = $request->id_ojk;
        $id_ojk    = Crypt::decrypt($id_ojk);

        $data     = DB::table('tb_ojkretribusi')
                    ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
                    ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
                    ->select('tb_ojkretribusi.*', 'tb_jenretribusi.*', 'tb_subretribusi.kode_sr', 'tb_subretribusi.nama_sr')
                    ->where('id_ojk', $id_ojk)
                    ->first();

        $id_jr   = $data->id_jr;

        $jenis    = DB::table('tb_jenretribusi')
                    ->where('status_jr', '1')
                    ->get();

        $subj     = DB::table('tb_subretribusi')
                    ->where('id_jr', $id_jr)
                    ->get();

        return view('admin.objekretribusi.edit', compact('data', 'jenis', 'id_ojk', 'subj'));
    }


}
