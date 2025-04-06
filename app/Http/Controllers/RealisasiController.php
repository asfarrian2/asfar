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

class RealisasiController extends Controller
{
    // View Data
    public function apbd(Request $request){

        //Menampilkan Data Utama Target
        $id_agency  = Auth::guard('operator')->user()->id_agency;
        $id_tahun   = Auth::guard('operator')->user()->id_tahun;

        $bulan = DB::table('tb_menu')
        ->get();

        $filter = DB::table('tb_menu')
        ->where('id_menu', $request->bulan)
        ->get();


        $view = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->first();
        //
        if ($filter){
            //Menampilkan Data Rincian Target
        $id_target = $view->id_target;
        $rincian = DB::table('tb_rtarget')
        ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->leftJoin('tb_realisasi', 'tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
        ->select('tb_rtarget.*', 'tb_realisasi.pagu_realisasi','tb_realisasi.bulan_realisasi','tb_ojkretribusi.nama_ojk', 'tb_ojkretribusi.kode_ojk', 'tb_subretribusi.nama_sr', 'tb_subretribusi.kode_sr', 'tb_jenretribusi.nama_jr', 'tb_jenretribusi.kode_jr')
        ->where('id_target',$id_target)
        ->orderBy('kode_ojk', 'ASC')
        ->get()
        ->groupBy('kode_jr')
        ->map(function($item, $key) {
            return $item->groupBy('kode_sr')
                ->map(function($item, $key) {
                    return $item->groupBy('kode_ojk');
                });
        });
        //

        $realisasi = DB::table('tb_realisasi')
        ->where('bulan_realisasi', $request->bulan)
        ->get();

        //

        $jumlah = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');


        return view('operator.realisasi.view', compact('view', 'rincian', 'jumlah', 'bulan', 'realisasi'));
        }else{
        //Menampilkan Data Rincian Target
        $id_target = $view->id_target;
        $rincian = DB::table('tb_rtarget')
        ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->leftJoin('tb_realisasi', 'tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
        ->select('tb_rtarget.*', 'tb_realisasi.pagu_realisasi','tb_ojkretribusi.nama_ojk', 'tb_ojkretribusi.kode_ojk', 'tb_subretribusi.nama_sr', 'tb_subretribusi.kode_sr', 'tb_jenretribusi.nama_jr', 'tb_jenretribusi.kode_jr')
        ->where('id_target',$id_target)
        ->orderBy('kode_ojk', 'ASC')
        ->get()
        ->groupBy('kode_jr')
        ->map(function($item, $key) {
            return $item->groupBy('kode_sr')
                ->map(function($item, $key) {
                    return $item->groupBy('kode_ojk');
                });
        });
        //
        //

        $jumlah = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');


        return view('operator.realisasi.view', compact('view', 'rincian', 'jumlah', 'bulan', 'realisasi'));
        }
    }

}
