<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RtargetController extends Controller
{

    //Get Select Objek Retribusi
    public function getsub($id_jr){
        $sub = DB::table('tb_subretribusi')
        ->where('status_sr', '1')
        ->where('id_jr', $id_jr)
        ->get();

        return response()->json($sub);
    }
    //

    //Get Select Objek Retribusi
    public function getobjek($id_sr){
        $ojk = DB::table('tb_ojkretribusi')
        ->where('status_ojk', '1')
        ->where('id_sr', $id_sr)
        ->get();

        return response()->json($ojk);
    }
    //

    //Simpan Data
     public function store(Request $request){

        $id_target      = $request->target;

        $uraian_rtarget  = $request->uraianrincian;
        $id_ojk          = $request->objek;
        $pagu_rtarget    = $request->pagurtarget;
        $pagu            = str_replace('.','', $pagu_rtarget);

        // Buat Kode Auto Target
        $id_rtarget=DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->latest('id_rtarget', 'DESC')
        ->first();

        $kodeobjek ="R".$id_target."-";

        if($id_rtarget == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_rtarget->id_rtarget, 12, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;
        // End Kode Auto Target

        $data = [
            'id_rtarget'     => $id,
            'uraian_rtarget' => $uraian_rtarget,
            'pagu_rtarget'   => $pagu,
            'status_rtarget' => '0',
            'pagu_prtarget'  => $pagu,
            'id_ojk'         => $id_ojk,
            'id_target'      => $id_target
        ];

        //Cek Total Antara Pagu Ketetapan dan Rincian
        $jumlah_target = DB::table('tb_target')
        ->where('id_target',$id_target)
        ->first();
        $total_target = $jumlah_target->pagu_target;

        $jumlah_rincian = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');
        //

        //validasi pagu rincian
        if ($jumlah_rincian+$pagu > $total_target) {
            return Redirect::back()->with(['warning' => 'Total Pagu pada Rincian Melebihi Pagu Target yang Telah Ditetapkan']);
        }else{

        //End validasi pagu target

        $simpan = DB::table('tb_rtarget')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
       }
     }


    //Tampilkan Halaman Edit Data
    public function edit(Request $request){

        $id_rtarget    = $request->id_rtarget;
        $id_rtarget    = Crypt::decrypt($id_rtarget);

        $data     = DB::table('tb_rtarget')
                    ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
                    ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
                    ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
                    ->select('tb_rtarget.*', 'tb_ojkretribusi.kode_ojk', 'tb_ojkretribusi.nama_ojk', 'tb_subretribusi.*')
                    ->where('id_rtarget', $id_rtarget)
                    ->first();

        $id_sr   = $data->id_sr;
        $id_jr   = $data->id_jr;

        $jenis     = DB::table('tb_jenretribusi')
                    ->where('status_jr', '1')
                    ->get();

        $sub       = DB::table('tb_subretribusi')
                    ->where('id_jr', $id_jr)
                    ->where('status_sr', '1')
                    ->get();

        $objek     = DB::table('tb_ojkretribusi')
                    ->where('id_sr', $id_sr)
                    ->where('status_ojk', '1')
                    ->get();

        return view('operator.target.murni.edit', compact('data', 'jenis', 'sub', 'objek'));
    }
    //

    //Update Data
    public function update($id_rtarget, Request $request){

        $id_rtarget     = Crypt::decrypt($id_rtarget);

        $uraian_rtarget = $request->uraian;
        $id_ojk         = $request->objek;
        $pagu_target    = $request->pagutarget;
        $pagu           = str_replace('.','', $pagu_target);

        $data = [
            'uraian_rtarget' => $uraian_rtarget,
            'id_ojk'         => $id_ojk,
            'pagu_prtarget'  => $pagu,
            'pagu_rtarget'   => $pagu
        ];

    //Cek Total Antara Pagu Ketetapan dan Rincian
    $rincian = DB::table('tb_rtarget')
                ->where('id_rtarget',$id_rtarget)
                ->first();
    $id_target = $rincian->id_target;
    $pagu_lama = $rincian->pagu_rtarget;

    $target = DB::table('tb_target')
                ->where('id_target',$id_target)
                ->first();

    $jumtarget = $target->pagu_target;

    $jumlah_rincian = DB::table('tb_rtarget')
    ->where('id_target',$id_target)
    ->sum('pagu_rtarget');
    //

    //validasi pagu rincian
    if ($jumlah_rincian-$pagu_lama+$pagu > $jumtarget) {
        return Redirect::back()->with(['warning' => 'Total Pagu Lebih Kecil Dari Pada Total Rincian Yang Telah Diinputkan']);
    }else{
        $update = DB::table('tb_rtarget')->where('id_rtarget', $id_rtarget)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
      }
     }
    //

    //Hapus Data
     public function delate($id_rtarget){

        $id_rtarget = Crypt::decrypt($id_rtarget);

        $delete = DB::table('tb_rtarget')->where('id_rtarget', $id_rtarget)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
     }



     //Simpan Data
     public function store_p(Request $request){

        $id_target      = $request->target;

        $uraian_rtarget  = $request->uraianrincian;
        $id_ojk          = $request->objek;
        $pagu_rtarget    = $request->pagurtarget;
        $pagu            = str_replace('.','', $pagu_rtarget);

        // Buat Kode Auto Target
        $id_rtarget=DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->latest('id_rtarget', 'DESC')
        ->first();

        $kodeobjek ="R".$id_target."-";

        if($id_rtarget == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_rtarget->id_rtarget, 12, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;
        // End Kode Auto Target

        $data = [
            'id_rtarget'     => $id,
            'uraian_rtarget' => $uraian_rtarget,
            'pagu_rtarget'   => '0',
            'status_rtarget' => '1',
            'pagu_prtarget'  => $pagu,
            'id_ojk'         => $id_ojk,
            'id_target'      => $id_target
        ];

        //Cek Total Antara Pagu Ketetapan dan Rincian
        $jumlah_target = DB::table('tb_target')
        ->where('id_target',$id_target)
        ->first();
        $total_target = $jumlah_target->pagu_target;

        $jumlah_rincian = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_prtarget');
        //

        //validasi pagu rincian
        if ($jumlah_rincian+$pagu > $total_target) {
            return Redirect::back()->with(['warning' => 'Total Pagu pada Rincian Melebihi Pagu Target yang Telah Ditetapkan']);
        }else{

        //End validasi pagu target

        $simpan = DB::table('tb_rtarget')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
       }
     }

     public function edit_p(Request $request){

        $id_rtarget    = $request->id_rtarget;
        $id_rtarget    = Crypt::decrypt($id_rtarget);

        $data     = DB::table('tb_rtarget')
                    ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
                    ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
                    ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
                    ->select('tb_rtarget.*', 'tb_ojkretribusi.kode_ojk', 'tb_ojkretribusi.nama_ojk', 'tb_subretribusi.*')
                    ->where('id_rtarget', $id_rtarget)
                    ->first();

        $id_sr   = $data->id_sr;
        $id_jr   = $data->id_jr;

        $jenis     = DB::table('tb_jenretribusi')
                    ->where('status_jr', '1')
                    ->get();

        $sub       = DB::table('tb_subretribusi')
                    ->where('id_jr', $id_jr)
                    ->where('status_sr', '1')
                    ->get();

        $objek     = DB::table('tb_ojkretribusi')
                    ->where('id_sr', $id_sr)
                    ->where('status_ojk', '1')
                    ->get();

        return view('operator.target.perubahan.edit', compact('data', 'jenis', 'sub', 'objek'));
    }
    //

    //Update Data
    public function update_p($id_rtarget, Request $request){

        $id_rtarget     = Crypt::decrypt($id_rtarget);

        $uraian_rtarget = $request->uraian;
        $id_ojk         = $request->objek;
        $pagu_target    = $request->pagutarget;
        $pagu           = str_replace('.','', $pagu_target);

        $data = [
            'uraian_rtarget' => $uraian_rtarget,
            'id_ojk'         => $id_ojk,
            'pagu_prtarget'  => $pagu
        ];

    //Cek Total Antara Pagu Ketetapan dan Rincian
    $rincian = DB::table('tb_rtarget')
                ->where('id_rtarget',$id_rtarget)
                ->first();
    $id_target = $rincian->id_target;
    $pagu_lama = $rincian->pagu_rtarget;

    $target = DB::table('tb_target')
                ->where('id_target',$id_target)
                ->first();

    $jumtarget = $target->pagu_target;

    $jumlah_rincian = DB::table('tb_rtarget')
    ->where('id_target',$id_target)
    ->sum('pagu_rtarget');
    //

    //validasi pagu rincian
    if ($jumlah_rincian-$pagu_lama+$pagu > $jumtarget) {
        return Redirect::back()->with(['warning' => 'Total Pagu Lebih Kecil Dari Pada Total Rincian Yang Telah Diinputkan']);
    }else{
        $update = DB::table('tb_rtarget')->where('id_rtarget', $id_rtarget)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
      }
     }
    //

    //Hapus Data
     public function delate_p($id_rtarget){

        $id_rtarget = Crypt::decrypt($id_rtarget);

        $delete = DB::table('tb_rtarget')->where('id_rtarget', $id_rtarget)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
     }




}
