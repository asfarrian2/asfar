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

        //Bar-Chart Target
        $penerimaan = DB::table('tb_bulan')
        ->leftJoin('tb_realisasi', 'tb_bulan.id_bulan', '=', 'tb_realisasi.id_bulan')
        ->select(
        'tb_bulan.id_bulan',
        'tb_bulan.nama_bulan',
        DB::raw('COALESCE(SUM(tb_realisasi.pagu_realisasi), 0) as total_realisasi'),
        )
        ->where('tb_bulan.id_tahun', $id_tahun)
        ->groupBy('tb_bulan.id_bulan', 'tb_bulan.nama_bulan')
        ->orderBy('tb_bulan.id_bulan')
        ->get();

        $labels = [];
        $data = [];

        foreach ($penerimaan as $item) {
        $labels[] = $item->nama_bulan;
        $data[]   = $item->total_realisasi; // Pastikan ini angka, bukan string
        }

        $realisasi = DB::table('tb_realisasi')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
         ->select(
        'tb_realisasi.id_bulan',
        'tb_bulan.nama_bulan',
        DB::raw('SUM(tb_realisasi.pagu_realisasi) as total_realisasi'),
        DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi AS t2 WHERE t2.id_bulan <= tb_realisasi.id_bulan) as jumlah_realisasi_kumulatif')
        )
        ->where('status_realisasi', '1')
        ->where('id_tahun', $id_tahun)
        ->groupBy('tb_realisasi.id_bulan', 'tb_bulan.nama_bulan') // ← Penting: MySQL 5.7 ke atas perlu ini!
        ->orderBy('tb_realisasi.id_bulan')
        ->get();

        $labels2 = [];
        $data2 = [];

        foreach ($realisasi as $item) {
        $labels3[] = $item->nama_bulan;
        $data2[]  = $item->jumlah_realisasi_kumulatif;
        }


         $triwulan = DB::table('tb_triwulan')
         ->leftJoin('tb_bulan', 'tb_triwulan.nilai_triwulan', '=', 'tb_bulan.nilaiy_bulan')
         ->leftJoin('tb_realisasi', 'tb_bulan.id_bulan', '=', 'tb_realisasi.id_bulan')
         ->select(
             'tb_triwulan.nama_triwulan',
             DB::raw('COALESCE(SUM(tb_realisasi.pagu_realisasi), 0) as realisasi_pertriwulan')
         )
         ->where('tb_triwulan.id_tahun', $id_tahun)
         ->groupBy('tb_triwulan.nama_triwulan')
         ->get();

        $labels3 = [];
        $data3 = [];

        foreach ($triwulan as $item) {
        $labels3[] = $item->nama_triwulan;
        $data3[]   = $item->realisasi_pertriwulan;
        }

        $rtriwulan = DB::table('tb_realisasi')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->leftJoin('tb_triwulan', 'tb_bulan.nilaiy_bulan', '=', 'tb_triwulan.nilai_triwulan')
        ->select(
            'tb_triwulan.nama_triwulan',
        DB::raw('(SELECT SUM(t2.pagu_realisasi) FROM tb_realisasi t2 LEFT JOIN tb_bulan b2 ON t2.id_bulan = b2.id_bulan WHERE b2.nilaiy_bulan <= tb_bulan.nilaiy_bulan) as jumlah_trealisasi_kumulatif')    )
        ->where('tb_bulan.id_tahun', $id_tahun)
        ->groupBy('tb_triwulan.nama_triwulan')
        ->get();

        $labels4 = [];
        $data4 = [];

        foreach ($rtriwulan as $item) {
        $labels4[] = $item->nama_triwulan;
        $data4[]   = $item->jumlah_trealisasi_kumulatif;
        }

        //

        return view('admin.dashboard.semua', compact('jtarget', 'penerimaan', 'labels', 'data', 'data2', 'triwulan', 'labels2', 'data3', 'realisasi', 'labels3', 'rtriwulan', 'labels4', 'data4'));
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
