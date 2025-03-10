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
use Illuminate\Support\Facades\Validator;

class TargetController extends Controller
{
    // (--------- Operator ----------)

    // View Data
    public function apbd(){

        $jenis = DB::table('tb_jenretribusi')
        ->where('status_jr', '1')
        ->get();

        $objek = DB::table('tb_ojkretribusi')
        ->where('status_ojk', '1')
        ->get();

        $sub = DB::table('tb_subretribusi')
        ->where('status_sr', '1')
        ->get();

        //Menampilkan Data Utama Target
        $id_agency  = Auth::guard('operator')->user()->id_agency;
        $id_tahun   = Auth::guard('operator')->user()->id_tahun;


        $view = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->first();
        //
        if (empty($view)){
            return view('operator.target.murni.view', compact('view'));
        }else{
        //Menampilkan Data Rincian Target
        $id_target = $view->id_target;
        $rincian = DB::table('tb_rtarget')
        ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->select('tb_rtarget.*','tb_ojkretribusi.nama_ojk', 'tb_ojkretribusi.kode_ojk', 'tb_subretribusi.nama_sr', 'tb_subretribusi.kode_sr', 'tb_jenretribusi.nama_jr', 'tb_jenretribusi.kode_jr')
        ->where('id_target',$id_target)
        ->get()
        ->groupBy('kode_jr')
        ->map(function($item, $key) {
            return $item->groupBy('kode_sr')
                ->map(function($item, $key) {
                    return $item->groupBy('kode_ojk');
                });
        });
        //

        $jumlah = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');

        return view('operator.target.murni.view', compact('view', 'rincian', 'jumlah', 'objek', 'sub', 'jenis'));
        }
    }

     //Simpan Data
     public function store(Request $request){

        $id_agency      = Auth::guard('operator')->user()->id_agency;
        $id_tahun       = Auth::guard('operator')->user()->id_tahun;
        $pagu_target    = $request->pagutarget;
        $dokumen        = $request->file('dokumen');
        $pagu           = str_replace('.','', $pagu_target);

        //Pemprosesan Dokumen
        $dinas = DB::table('tb_agency')
                ->where('id_agency', $id_agency)
                ->first();
        $nama_dinas = $dinas->nama_agency;

        if ($dokumen) {
            // Proses file
            $validator = Validator::make($request->all(),[
                'dokumen' => 'required|mimes:pdf|max:1024',
            ], [
                'dokumen.max' => 'Upload gagal karena ukuran file terlalu besar. Maksimal ukuran file adalah 1MB',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with(['warning' => $validator->messages()->first()]);
            }

            $nama_dokumen = 'Surat Usulan Target Retribusi APBD '. $id_tahun.' '.$nama_dinas.'.'. $dokumen->getClientOriginalExtension();
        } else {
            return Redirect::back()->with(['warning' => 'Dokumen Belum Diupload']);
        }

        //Save Dokumen
        $dokumen->move('upload/dokumen/targetapbd/', $nama_dokumen);

        // Buat Kode Auto Target
        $id_target=DB::table('tb_target')
        ->where('id_tahun',$id_tahun)
        ->latest('id_target', 'DESC')
        ->first();

        $kodeobjek ="T".$id_tahun."-";

        if($id_target == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($id_target->id_target, 6, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$kodeobjek.$nomorurut;
        // End Kode Auto Target

        $data = [
            'id_target'     => $id,
            'jen_target'    => '1',
            'pagu_target'   => $pagu,
            'pagu_ptarget'  => $pagu,
            'surat_apbd'    => $nama_dokumen,
            'status_target' => '0',
            'id_tahun'      => $id_tahun,
            'id_agency'     => $id_agency
        ];

        //validasi pagu target
        if ($pagu == '0') {
            return Redirect::back()->with(['warning' => 'Isi Pagu Target Dengan Benar']);
        }else{

        //End validasi pagu target

        $simpan = DB::table('tb_target')->insert($data);
        if ($simpan) {
            return Redirect('/opt/targetapbd')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
       }
     }

     //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_target    = $request->id_target;
        $id_target    = Crypt::decrypt($id_target);
        $target       = DB::table('tb_target')
                        ->where('id_target', $id_target)
                        ->first();

        return view('operator.target.murni.edittarget', compact('target'));
    }

    //Update Data
    public function update($id_target, Request $request){

            $id_target      = Crypt::decrypt($id_target);
            $id_agency      = Auth::guard('operator')->user()->id_agency;
            $id_tahun       = Auth::guard('operator')->user()->id_tahun;
            $pagu_target    = $request->pagutarget;
            $dokumen        = $request->file('dokumen');
            $pagu           = str_replace('.','', $pagu_target);

            //Pemprosesan Dokumen
        $dinas = DB::table('tb_agency')
                ->where('id_agency', $id_agency)
                ->first();
        $nama_dinas = $dinas->nama_agency;

        if ($dokumen) {
            // Proses file
            $validator = Validator::make($request->all(),[
                'dokumen' => 'required|mimes:pdf|max:1024',
            ], [
                'dokumen.max' => 'Upload gagal karena ukuran file terlalu besar. Maksimal ukuran file adalah 1MB',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with(['warning' => $validator->messages()->first()]);
            }

            $nama_dokumen = 'Surat Usulan Target Retribusi APBD '. $id_tahun.' '.$nama_dinas.'.'. $dokumen->getClientOriginalExtension();
        } else {
            return Redirect::back()->with(['warning' => 'Dokumen Belum Diupload']);
        }

        //Save Dokumen
        $dokumen->move('upload/dokumen/targetapbd/', $nama_dokumen);


            $data = [
                'pagu_ptarget'   => $pagu,
                'surat_apbd'    => $nama_dokumen,
                'pagu_target'   => $pagu
            ];

        //Cek Total Antara Pagu Ketetapan dan Rincian
        $jumlah_rincian = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');
        //

        //validasi pagu rincian
        if ($jumlah_rincian > $pagu) {
            return Redirect::back()->with(['warning' => 'Total Pagu Lebih Kecil Dari Pada Total Rincian Yang Telah Diinputkan']);
        }else{
            $update = DB::table('tb_target')->where('id_target', $id_target)->update($data);
            if ($update) {
                return Redirect('/opt/targetapbd')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
            }
          }
         }

}
