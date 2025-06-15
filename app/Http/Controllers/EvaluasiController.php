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
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluasiController extends Controller
{
    public function view( Request $request){

        $id_agency = Auth::guard('operator')->user()->id_agency;

        $triwulan = DB::table('tb_triwulan')
        ->get();

        $id_triwulan = $request->triwulan;

        if ($id_triwulan){
            $id_triwulan = Crypt::decrypt($id_triwulan);

            $evaluasi = DB::table('tb_evaluasi')
            ->where('id_agency', $id_agency)
            ->where('id_triwulan', $id_triwulan)
            ->first();

        }
        else{
            $evaluasi = [];
        }
        $status = DB::table('tb_triwulan')
                ->where('id_triwulan', $id_triwulan)
                ->first();


    return view ('operator.evaluasi.view', compact('triwulan', 'status', 'evaluasi'));
    }

    public function store( Request $request){

        $id_agency = Auth::guard('operator')->user()->id_agency;
        $id_triwulan    = $request->id_tw;

        $evaluasi =DB::table('tb_evaluasi')
        ->where('id_triwulan', $id_triwulan)
        ->orderBy('id_evaluasi', 'DESC')
        ->first();

        $kodeobjek = "-EV-";

        if($evaluasi == null){
            $nomorurut = "0001";
        }else{
            $nomorurut = substr($evaluasi->id_evaluasi, 9, 4) + 1;
            $nomorurut = str_pad($nomorurut, 4, "0", STR_PAD_LEFT);
        }
        $id=$id_triwulan.$kodeobjek.$nomorurut;

        $fpendukung     = $request->fpendukung;
        $fpenghambat    = $request->fpenghambat;
        $tindaklanjut   = $request->tindaklanjut;

        $data = [
            'id_evaluasi'      => $id,
            'fpendukung'       => $fpendukung,
            'fpenghambat'      => $fpenghambat,
            'tindaklanjut'     => $tindaklanjut,
            'id_triwulan'      => $id_triwulan,
            'id_agency'        => $id_agency
        ];

        $simpan = DB::table('tb_evaluasi')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }

         //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_evaluasi    = $request->id_evaluasi;
        $id_evaluasi    = Crypt::decrypt($id_evaluasi);
        $evaluasi        = DB::table('tb_evaluasi')
                           ->where('id_evaluasi', $id_evaluasi)
                           ->first();

        return view('operator.evaluasi.edit', compact('evaluasi'));
    }

    //Update Data
    public function update($id_evaluasi, Request $request){

        $id_evaluasi   = Crypt::decrypt($id_evaluasi);
        $fpendukung     = $request->fpendukung;
        $fpenghambat    = $request->fpenghambat;
        $tindaklanjut   = $request->tindaklanjut;

        $data = [
            'fpendukung'   => $fpendukung,
            'fpenghambat'  => $fpenghambat,
            'tindaklanjut' => $tindaklanjut
        ];

        $update = DB::table('tb_evaluasi')->where('id_evaluasi', $id_evaluasi)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
     }

     //Posting Target Data
     public function post($id_evaluasi){

        $id_evaluasi    = Crypt::decrypt($id_evaluasi);

        $data = [
            'status_evaluasi' => '1'
        ];

        //validasi pagu rincian
        $update = DB::table('tb_evaluasi')->where('id_evaluasi', $id_evaluasi)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Target Berhasil Diposting']);
        } else {
            return Redirect::back()->with(['warning' => 'Target Gagal Diposting']);
        }
    }

    // //(------------------------Begin Target Hak Admin----------------------------//
        public function adm_view(Request $request){

        //Menampilkan Data Utama Target
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $triwulan = DB::table('tb_triwulan')
        ->where('id_tahun', $tahun_sekarang)
        ->get();

        $select_triwulan      = $request->triwulan;

        if ($select_triwulan) {
        $select_triwulan = Crypt::decrypt($select_triwulan);

        $pilih_triwulan  = DB::table('tb_triwulan')
        ->where('id_triwulan', $select_triwulan)
        ->first();


        $target = DB::table('tb_target')
        ->leftJoin('tb_agency', 'tb_target.id_agency', '=', 'tb_agency.id_agency')
        ->where('id_tahun', $tahun_sekarang)
        ->get();

        $evaluasi= DB::table('tb_evaluasi')
        ->where('id_triwulan', $select_triwulan)
        ->where('status_evaluasi', '1')
        ->get();

        $realisasi = array();
        foreach ($target as $t) {
            $realisasi[$t->id_target] = DB::table('tb_realisasi')
            ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
            ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
            ->where('tb_rtarget.id_target', $t->id_target)
            ->where('tb_bulan.nilaiy_bulan', '<=', $pilih_triwulan->nilai_triwulan)
            ->where('status_realisasi', '1')
            ->sum('pagu_realisasi');
        }

        $totalrealisasi = DB::table('tb_realisasi')
            ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
            ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
            ->where('tb_bulan.nilaiy_bulan', '<=', $pilih_triwulan->nilai_triwulan)
            ->where('status_realisasi', '1')
            ->sum('pagu_realisasi');

        $totaltarget = DB::table('tb_target')
        ->where('id_tahun', $tahun_sekarang)
        ->sum('pagu_target');


        } else {
            $pilih_triwulan = [];
            $target = [];
            $evaluasi = [];
            $realisasi = [];
            $totalrealisasi = [];
            $totaltarget = [];
        }

        return view('admin.evaluasi.view', compact('triwulan', 'pilih_triwulan', 'target', 'evaluasi', 'realisasi', 'totalrealisasi', 'totaltarget'));
    }

    public function Batal ($id_evaluasi){

         $id_evaluasi = Crypt::decrypt($id_evaluasi);

         $data = [
            'status_evaluasi' => '0'
        ];

        //validasi pagu rincian
        $update = DB::table('tb_evaluasi')->where('id_evaluasi', $id_evaluasi)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Evaluasi Berhasil Dibatalkan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Evaluasi Gagal Dibatalkan']);
        }
    }

    public function adm_rview($id_evaluasi){

        $id_evaluasi = Crypt::decrypt($id_evaluasi);
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $evaluasi    = DB::table('tb_evaluasi')
                       ->leftJoin('tb_triwulan', 'tb_evaluasi.id_triwulan', '=', 'tb_triwulan.id_triwulan')
                       ->leftJoin('tb_agency', 'tb_evaluasi.id_agency', '=', 'tb_agency.id_agency')
                       ->select('tb_evaluasi.*', 'tb_triwulan.nilai_triwulan', 'tb_agency.nama_agency')
                       ->where('id_evaluasi', $id_evaluasi)
                       ->first();

        $target      = DB::table('tb_target')
                        ->where('id_tahun', $tahun_sekarang)
                        ->where('id_agency', $evaluasi->id_agency)
                        ->first();

        $nilai_triwulan = $evaluasi->nilai_triwulan;
        $id_target = $target->id_target;

        if ($nilai_triwulan <= 3){
            // Menampilkan Data Rincian Realisasi Anggaran Murni
            $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->leftJoin('tb_realisasi', 'tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
            ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
           ->select('tb_rtarget.*',
                'tb_realisasi.pagu_realisasi',
                'tb_realisasi.id_realisasi',
                'tb_realisasi.id_bulan',
                'tb_realisasi.status_realisasi',
                'tb_ojkretribusi.nama_ojk',
                'tb_ojkretribusi.kode_ojk',
                'tb_subretribusi.nama_sr',
                'tb_subretribusi.kode_sr',
                'tb_jenretribusi.nama_jr',
                'tb_jenretribusi.kode_jr',
                'tb_bulan.nilaiy_bulan',
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 1) as pagu_realisasi_tw1'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 2) as pagu_realisasi_tw2'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 3) as pagu_realisasi_tw3'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 4) as pagu_realisasi_tw4'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan <='.$nilai_triwulan.') as pagu_totaltw'),
                DB::raw('( ROUND(( (SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan <= ' . $nilai_triwulan . ') / pagu_rtarget ) * 100) ) as persen_realisasi'),


                )

            ->where('id_target', $id_target)
            ->where('status_rtarget', '0')
            ->orderBy('kode_ojk', 'ASC')
            ->groupBy('id_rtarget')
            ->get()
            ->groupBy('kode_jr')
            ->map(function ($item, $key) {
                return $item->groupBy('kode_sr')
                    ->map(function ($item, $key) {
                        return $item->groupBy('kode_ojk');
                    });
            });

            $jumlah = DB::table('tb_rtarget')
            ->where('id_target',$id_target)
            ->sum('pagu_rtarget');

            }else{
            // Menampilkan Data Rincian Realisasi Anggaran Perubahan
            $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->rightJoin('tb_realisasi', 'tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
            ->rightJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
            ->select('tb_rtarget.*',
                'tb_realisasi.pagu_realisasi',
                'tb_realisasi.id_realisasi',
                'tb_realisasi.id_bulan',
                'tb_realisasi.status_realisasi',
                'tb_ojkretribusi.nama_ojk',
                'tb_ojkretribusi.kode_ojk',
                'tb_subretribusi.nama_sr',
                'tb_subretribusi.kode_sr',
                'tb_jenretribusi.nama_jr',
                'tb_jenretribusi.kode_jr',
                'tb_bulan.nilaiy_bulan',
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 1) as pagu_realisasi_tw1'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 2) as pagu_realisasi_tw2'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 3) as pagu_realisasi_tw3'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan = 4) as pagu_realisasi_tw4'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi
                          INNER JOIN tb_bulan ON tb_realisasi.id_bulan = tb_bulan.id_bulan
                          WHERE tb_realisasi.id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan <='.$nilai_triwulan.') as pagu_totaltw'),
                DB::raw('( ROUND(( (SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan <= ' . $nilai_triwulan . ') / pagu_prtarget ) * 100, 2) ) as persen_realisasi'),


                )
            ->where('id_target', $id_target)
            ->orderBy('kode_ojk', 'ASC')
            ->groupBy('id_rtarget')
            ->get()
            ->groupBy('kode_jr')
            ->map(function($item, $key) {
                return $item->groupBy('kode_sr')
                    ->map(function($item, $key) {
                        return $item->groupBy('kode_ojk');
                    });
            });

            $jumlah = DB::table('tb_rtarget')
            ->where('id_target',$id_target)
            ->sum('pagu_prtarget');
            } //endif


        $count = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        // ->where('id_bulan', $id_bulan)
        ->where('tb_target.id_target',$id_target)
        ->where('status_realisasi', '1')
        ->count();

        //

        $total = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        // ->where('id_bulan', $id_bulan)
        ->sum('pagu_realisasi');

        $total_tw1 = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target', 'tb_bulan.nilaiy_bulan')
        ->where('id_target',$id_target)
        ->where('tb_bulan.nilaiy_bulan', '1')
        ->sum('pagu_realisasi');

        $total_tw2 = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target', 'tb_bulan.nilaiy_bulan')
        ->where('id_target',$id_target)
        ->where('tb_bulan.nilaiy_bulan', '2')
        ->sum('pagu_realisasi');

        $total_tw3 = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target', 'tb_bulan.nilaiy_bulan')
        ->where('id_target',$id_target)
        ->where('tb_bulan.nilaiy_bulan', '3')
        ->sum('pagu_realisasi');

        $total_tw4 = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target', 'tb_bulan.nilaiy_bulan')
        ->where('id_target',$id_target)
        ->where('tb_bulan.nilaiy_bulan', '4')
        ->sum('pagu_realisasi');

        $total_sekarang = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_bulan', 'tb_realisasi.id_bulan', '=', 'tb_bulan.id_bulan')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target', 'tb_bulan.nilaiy_bulan')
        ->where('id_target',$id_target)
        ->where('tb_bulan.nilaiy_bulan', '<=' , $nilai_triwulan)
        ->sum('pagu_realisasi');

        return view('admin.evaluasi.rview', compact('rincian', 'evaluasi', 'nilai_triwulan', 'target', 'jumlah', 'total', 'count', 'total_tw1', 'total_tw2', 'total_tw3', 'total_tw4', 'total_sekarang'));

    }

}
