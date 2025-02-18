<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AgencyController extends Controller
{
    //Tampilkan Data
    public function view(){
        $view = DB::table('tb_agency')
        ->leftJoin('tb_operator', 'tb_agency.id_agency', 'tb_operator.id_agency')
        ->select('tb_agency.*', DB::raw('COUNT(tb_operator.id_agency) as jumlah'))
        ->groupBy('tb_agency.id_agency')
        ->get();
        return view('admin.agency.view', compact('view'));
    }

     //Simpan Data
     public function store(Request $request){

        $id_agency=DB::table('tb_agency')
        ->latest('id_agency', 'DESC')
        ->first();

        $kodeobjek ="AGN-";

        if($id_agency == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_agency->id_agency, 4, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;

        $nama_agency    = $request->nama_agency;
        $kepala_agency  = $request->nama_pejabat;
        $nip_agency     = $request->nip;

        $data = [
            'id_agency'     => $id,
            'nama_agency'   => $nama_agency,
            'kepala_agency' => $kepala_agency,
            'nip_agency'    => $nip_agency,
        ];

        $simpan = DB::table('tb_agency')->insert($data);
        if ($simpan) {
            return Redirect('/admin/agency')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }

     //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_agency    = $request->id_agency;
        $tb_agency    = DB::table('tb_agency')
                        ->where('id_agency', $id_agency)
                        ->first();

        return view('admin.agency.edit', compact('id_agency', 'tb_agency'));
    }

    //Update Data
    public function update($id_agency, Request $request){

        $id_agency      = Crypt::decrypt($id_agency);
        $nama_agency    = $request->nama_agency;
        $kepala_agency  = $request->nama_pejabat;
        $nip_agency     = $request->nip;

        $data = [
            'nama_agency'   => $nama_agency,
            'kepala_agency' => $kepala_agency,
            'nip_agency'    => $nip_agency,
        ];

        $update = DB::table('tb_agency')->where('id_agency', $id_agency)->update($data);
        if ($update) {
            return Redirect('/admin/agency')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
     }

     //Hapus Data
     public function delate($id_agency){

        $id_agency = Crypt::decrypt($id_agency);

        $delete = DB::table('tb_agency')->where('id_agency', $id_agency)->delete();
        if ($delete) {
            return redirect('/admin/agency')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
     }

}
