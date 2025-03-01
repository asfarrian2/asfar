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

        //Validasi Kode Rekening
        $cekkode = DB::table('tb_jenretribusi')
        ->where('kode_jr', '=', $kode_jr)
        ->count();
         if ($cekkode > 0) {
        return Redirect::back()->with(['warning' => 'Kode Jenis Retribusi Sudah Digunakan']);
         }else{

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
     }

     //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_jr    = $request->id_jr;
        $id_jr    = Crypt::decrypt($id_jr);

        $tb_jr    = DB::table('tb_jenretribusi')
                    ->where('id_jr', $id_jr)
                    ->first();

        return view('admin.jenisretribusi.edit', compact('id_jr', 'tb_jr'));
    }

     //Update Data
     public function update($id_jr, Request $request){

        $id_jr      = Crypt::decrypt($id_jr);
        $kode_lama  = $request->kode_lama;
        $kode       = $request->kode;
        $nama       = $request->nama;

        $cek = DB::table('tb_jenretribusi')
        ->where('kode_jr', $kode)
        ->where('kode_jr', '!=', $kode_lama)
        ->count();
        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Kode Akun Jenis Retribusi Sudah Digunakan']);
        }else{
        $data = [
            'kode_jr'   => $kode,
            'nama_jr'   => $nama
        ];
          $update = DB::table('tb_jenretribusi')->where('id_jr', $id_jr)->update($data);
        if ($update) {
            return Redirect('/admin/jenisretribusi')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
        }
      }

     //Hapus Data
     public function delate($id_jr)
     {
        $id = Crypt::decrypt($id_jr);

        $cek = DB::table('tb_subretribusi')
        ->where('id_jr', $id)
        ->count();

        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Kode Akun Telah Digunakan, Data Tidak Dapat Dihapus']);
        }else{
            $delete = DB::table('tb_jenretribusi')->where('id_jr', $id)->delete();
            if ($delete) {
                return redirect('/admin/jenisretribusi')->with(['success' => 'Data Berhasil Dihapus']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
            }
        }
     }

    //Status Data
    public function status($id_jr)
    {
        $id   = Crypt::decrypt($id_jr);

        $data = DB::table('tb_jenretribusi')
        ->where('id_jr', $id)
        ->first();

        $status_jr = $data->status_jr;

        $aktif = [
            'status_jr' => '1',
        ];

        $nonaktif = [
            'status_jr' => '0',
        ];

        if($status_jr == '0'){
            $update = DB::table('tb_jenretribusi')->where('id_jr', $id)->update($aktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Diaktifkan.']);
            }

        }else{
            $update = DB::table('tb_jenretribusi')->where('id_jr', $id)->update($nonaktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dinonaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dinonaktifkan.']);
            }
        }
    }





}
