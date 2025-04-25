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

        //Menampilkan Data Utama Target
        $id_agency  = Auth::guard('operator')->user()->id_agency;
        $id_tahun   = Auth::guard('operator')->user()->id_tahun;

        //Cek Keberadaan Data
        $cektarget = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->count();

        $cekrealisasi = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target', 'tb_target.id_agency', 'tb_target.id_tahun')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->count();
        //-----------------------------

        $target = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->first();

        if($cekrealisasi == 0) {
            $realisasi=0;
        }else{
        $realisasi = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        ->where('status_realisasi', '1')
        ->where('tb_target.id_target', $target->id_target)
        ->sum('pagu_realisasi');
        }


        return view('operator.dashboard.view', compact('target', 'realisasi', 'cektarget', 'cekrealisasi'));
    }

}
