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

class DashboardController extends Controller
{
    // Admin
    public function all(){

        $id_tahun = Auth::guard('admin')->user()->id_tahun;

        $jtarget = DB::table('tb_target')
        ->where('id_tahun', $id_tahun)
        ->sum('pagu_target');

        return view('admin.dashboard.semua', compact('jtarget'));
    }


    // Operator
    public function operator(){
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
            $realisasi=[];
            return view('operator.dashboard.view', compact('view', 'realisasi'));
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

        $realisasi = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        ->where('status_realisasi', '1')
        ->where('tb_target.id_target', $id_target)
        ->sum('pagu_realisasi');


        return view('operator.dashboard.view', compact('view', 'realisasi'));
    }
    }

}
