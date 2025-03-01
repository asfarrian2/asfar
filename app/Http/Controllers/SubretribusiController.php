<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class SubretribusiController extends Controller
{
    public function view(){
        $view = DB::table('tb_subretribusi')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->select('tb_subretribusi.*', 'tb_jenretribusi.kode_jr', 'tb_jenretribusi.nama_jr')
        ->get();

        $jenis = DB::table('tb_jenretribusi')
        ->where('status_jr', '1')
        ->get();


        return view('admin.subretribusi.view', compact('view', 'jenis'));
    }

    //Tambah Data
    public function store(Request $request){

        $id_sr=DB::table('tb_subretribusi')
        ->latest('id_sr',   'DESC')
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
        $cekkode = DB::table('tb_subretribusi')
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

            $simpan = DB::table('tb_subretribusi')->insert($data);
            if ($simpan) {
                return Redirect('/admin/subretribusi')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
            }
        }
     }

    //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_sr    = $request->id_sr;
        $id_sr    = Crypt::decrypt($id_sr);

        $data     = DB::table('tb_subretribusi')
                    ->where('id_sr', $id_sr)
                    ->first();

        $jenis    = DB::table('tb_jenretribusi')
                    ->where('status_jr', '1')
                    ->get();

        return view('admin.subretribusi.edit', compact('data', 'jenis', 'id_sr'));
    }

    //Update Data
    public function update($id_sr, Request $request){

        $id_sr      = Crypt::decrypt($id_sr);
        $kode_lama  = $request->kode_lama;
        $kode       = $request->kode;
        $nama       = $request->nama;
        $jenis      = $request->jenis;

        $cek = DB::table('tb_subretribusi')
        ->where('kode_sr', $kode)
        ->where('kode_sr', '!=', $kode_lama)
        ->count();
        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Kode Akun Sub Retribusi Sudah Digunakan']);
        }else{
        $data = [
            'kode_sr' => $kode,
            'nama_sr' => $nama,
            'id_jr'   => $jenis
        ];

        $update = DB::table('tb_subretribusi')->where('id_sr', $id_sr)->update($data);
        if ($update) {
            return Redirect('/admin/subretribusi')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
        }
     }

    //Status Data
    public function status($id_sr)
    {
        $id_sr   = Crypt::decrypt($id_sr);

        $data = DB::table('tb_subretribusi')
        ->where('id_sr', $id_sr)
        ->first();

        $status_sr = $data->status_sr;

        $aktif = [
            'status_sr' => '1',
        ];

        $nonaktif = [
            'status_sr' => '0',
        ];

        if($status_sr == '0'){
            $update = DB::table('tb_subretribusi')->where('id_sr', $id_sr)->update($aktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Diaktifkan.']);
            }

        }else{
            $update = DB::table('tb_subretribusi')->where('id_sr', $id_sr)->update($nonaktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dinonaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dinonaktifkan.']);
            }
        }

    }



}
