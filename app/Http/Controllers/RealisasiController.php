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
        //Cek Keberadaan Data
        $cektarget = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->where('status_target', '>', 0)
        ->count();

        if($cektarget == 0){
            return view('operator.halamanvalid.realisasi');
        }else{

        $bulan      = $request->bulan;

        $select_bulan = DB::table('tb_bulan')
        ->where('id_tahun', $id_tahun)
        ->get();

        // $sekarang = DB::table('tb_bulan')
        // ->where('id_bulan',$bulan)
        // ->first();

        // $sebelumnya = DB::table('tb_bulan')
        // ->where('nilaix_bulan',$sekarang->nilaix_bulan - 1)
        // ->first();


        $view = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->first();
        //
        if ($bulan) {
        $bulan = Crypt::decrypt($bulan);
        $filter = DB::table('tb_bulan')
        ->where('id_bulan', $bulan)
        ->first();

        $id_target = $view->id_target;

        if ($filter->tipe_bulan == 1) {
        // Menampilkan Data Rincian Realisasi Anggaran Murni
        $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->leftJoin('tb_realisasi', function ($join) use ($bulan) {
                $join->on('tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
                    ->where('tb_realisasi.id_bulan', $bulan);
            })
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
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan < ' . $bulan . ') as pagu_realisasi_sebelumnya'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $bulan . ') as pagu_realisasi_sekarang')
            )
            ->where('id_target', $id_target)
            ->where('status_rtarget', '0')
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


        $count = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        ->where('id_bulan', $bulan)
        ->where('tb_target.id_target',$id_target)
        ->where('status_realisasi', '1')
        ->count();

        //

        $jumlah = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_rtarget');

        $total = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', $bulan)
        ->sum('pagu_realisasi');

        $total_sebelumnya = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<' , $bulan)
        ->sum('pagu_realisasi');

        $total_sekarang = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<=' , $bulan)
        ->sum('pagu_realisasi');

        return view('operator.realisasi.view', compact('view', 'rincian', 'jumlah', 'select_bulan', 'total', 'filter', 'count', 'total_sebelumnya', 'total_sekarang'));
        }else{ //Menampilkan Data Rincian Realisasi Anggaran Perubahan

            $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->leftJoin('tb_realisasi', function ($join) use ($bulan) {
                $join->on('tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
                    ->where('tb_realisasi.id_bulan', $bulan);
            })
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
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan < ' . $bulan . ') as pagu_realisasi_sebelumnya'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $bulan . ') as pagu_realisasi_sekarang')
            )
            ->where('id_target', $id_target)
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

        $count = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        ->where('id_bulan', $bulan)
        ->where('tb_target.id_target',$id_target)
        ->where('status_realisasi', '1')
        ->count();

        //

        $jumlah = DB::table('tb_rtarget')
        ->where('id_target',$id_target)
        ->sum('pagu_prtarget');

        $total = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', $bulan)
        ->sum('pagu_realisasi');

        $total_sebelumnya = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<' , $bulan)
        ->sum('pagu_realisasi');

        $total_sekarang = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<=' , $bulan)
        ->sum('pagu_realisasi');

        return view('operator.realisasi.view', compact('view', 'rincian', 'jumlah', 'select_bulan', 'total', 'filter', 'count', 'total_sebelumnya', 'total_sekarang'));
        }
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

        $total = [];

        return view('operator.realisasi.view', compact('view', 'rincian', 'jumlah', 'select_bulan', 'total'));
        }
    }
    }

    public function tambah(Request $request){

        $id_rtarget = $request->id_rtarget;
        $rtarget = Crypt::decrypt($id_rtarget);
        $id_bulan = $request->id_bulan;
        $bulan = Crypt::decrypt($id_bulan);

        $data = DB::table('tb_rtarget')
        ->where('id_rtarget', $rtarget)
        ->first();

        return view('operator.realisasi.tambah', compact('id_rtarget', 'id_bulan', 'data'));
    }

     //Simpan Data
     public function store(Request $request){

        $bulan    = $request->bulan;
        $id_bulan = Crypt::decrypt($bulan);

        $id_rtarget = $request->rtarget;
        $id_rtarget = Crypt::decrypt($id_rtarget);

        $id_realisasi =DB::table('tb_realisasi')
        ->where('id_bulan', $id_bulan)
        ->orderBy('id_realisasi', 'DESC')
        ->first();

        $kodeobjek =".R-";

        if($id_realisasi == null){
            $nomorurut = "00001";
        }else{
            $nomorurut = substr($id_realisasi->id_realisasi, 10, 5) + 1;
            $nomorurut = str_pad($nomorurut, 5, "0", STR_PAD_LEFT);
        }
        $id=$id_bulan.$kodeobjek.$nomorurut;

        $realisasi = $request->realisasi;
        $pagu = str_replace('.','', $realisasi);


        $data = [
            'id_realisasi'     => $id,
            'pagu_realisasi'   => $pagu,
            'status_realisasi' => '0',
            'id_rtarget'       => $id_rtarget,
            'id_bulan'         => $id_bulan,
        ];

        $simpan = DB::table('tb_realisasi')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
     }

    //Tampilkan Halaman Edit Data
     public function edit(Request $request){

        $id_realisasi    = $request->id_realisasi;
        $id_realisasi    = Crypt::decrypt($id_realisasi);
        $data            = DB::table('tb_realisasi')
                           ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
                           ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_rtarget.uraian_rtarget')
                           ->where('id_realisasi', $id_realisasi)
                           ->first();

        return view('operator.realisasi.edit', compact('data'));
    }

     //Update Data
    public function update($id_realisasi, Request $request){

        $id_realisasi   = Crypt::decrypt($id_realisasi);
        $realisasi      = $request->realisasi;
        $pagu           = str_replace('.','', $realisasi);

        $data = [
            'pagu_realisasi'   => $pagu
        ];

        $update = DB::table('tb_realisasi')->where('id_realisasi', $id_realisasi)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dirubah']);
        }
     }

      //Update Data
    public function posting($id_bulan){

        $id_bulan   = Crypt::decrypt($id_bulan);
        $id_agency  = Auth::guard('operator')->user()->id_agency;
        $id_tahun   = Auth::guard('operator')->user()->id_tahun;

        //Mencari Nilai ID Target
        $id_target = DB::table('tb_target')
        ->where('id_agency',$id_agency)
        ->where('id_tahun',$id_tahun)
        ->first();
        //----------------------------

        //Mencari Data Bulan
        $bulan = DB::table('tb_bulan')
        ->where('id_bulan',$id_bulan)
        ->first();

        $tipe_bulan = $bulan->tipe_bulan;
        //----------------------------

        //Cek Data Sebelum Posting
        $countrapbd = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_rtarget.status_rtarget', 'tb_target.id_target')
        ->where('status_realisasi', '0')
        ->where('tb_target.id_target', $id_target->id_target)
        ->where('id_bulan', $id_bulan)
        ->where('status_rtarget', '0')
        ->count();

        $counttapbd = DB::table('tb_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_rtarget.*', 'tb_target.id_target')
        ->where('tb_target.id_target', $id_target->id_target)
        ->where('status_rtarget', '0')
        ->count();

        $countrapbdp = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_rtarget.status_rtarget', 'tb_target.id_target')
        ->where('status_realisasi', '0')
        ->where('tb_target.id_target', $id_target->id_target)
        ->where('id_bulan', $id_bulan)
        ->count();

        $counttapbdp = DB::table('tb_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_rtarget.*', 'tb_target.id_target')
        ->where('tb_target.id_target', $id_target->id_target)
        ->count();
        //----------------------------

            if($tipe_bulan == 1){
                if($counttapbd == $countrapbd){
                $data = [
                    'status_realisasi'   => '1'
                ];

                $update = DB::table('tb_realisasi')
                ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
                ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
                ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
                ->where('status_realisasi', '0')
                ->where('tb_target.id_target', $id_target->id_target)
                ->where('id_bulan', $id_bulan)
                ->update($data);
                if ($update) {
                    return Redirect::back()->with(['success' => 'Data Berhasil Diposting']);
                } else {
                    return Redirect::back()->with(['warning' => 'Data Gagal Diposting']);
                }
            }else{
                return Redirect::back()->with(['warning' => 'Data Gagal Diposting, Terdapat Data Realisasi yang Masih Belum Diinput']);
            }

        }else{
            if($counttapbdp == $countrapbdp){
                $data = [
                    'status_realisasi'   => '1'
                ];

                $update = DB::table('tb_realisasi')
                ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
                ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
                ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
                ->where('status_realisasi', '0')
                ->where('tb_target.id_target', $id_target->id_target)
                ->where('id_bulan', $id_bulan)
                ->update($data);
                if ($update) {
                    return Redirect::back()->with(['success' => 'Data Berhasil Diposting']);
                } else {
                    return Redirect::back()->with(['warning' => 'Data Gagal Diposting']);
                }
            }else{
                return Redirect::back()->with(['warning' => 'Data Gagal Diposting, Terdapat Data Realisasi yang Masih Belum Diinput']);
            }

        }
    }

    // //(------------------------Begin Target Hak Admin----------------------------//
    public function adm_view(Request $request){

        //Menampilkan Data Utama Target
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $bulan = DB::table('tb_bulan')
        ->where('id_tahun', $tahun_sekarang)
        ->get();

        $select_bulan      = $request->bulan;

        if ($select_bulan) {
        $select_bulan = Crypt::decrypt($select_bulan);

        $pilih_bulan  = DB::table('tb_bulan')
        ->where('id_bulan', $select_bulan)
        ->first();


        $target = DB::table('tb_target')
        ->leftJoin('tb_agency', 'tb_target.id_agency', '=', 'tb_agency.id_agency')
        ->where('id_tahun', $tahun_sekarang)
        ->get();

        $realisasi_bulan = array();
        foreach ($target as $t) {
            $realisasi_bulan[$t->id_target] = DB::table('tb_realisasi')
            ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
            ->where('tb_rtarget.id_target', $t->id_target)
            ->where('id_bulan', $select_bulan)
            ->where('status_realisasi', '1')
            ->sum('pagu_realisasi');
        }

        $realisasi_sebelumnya = array();
        foreach ($target as $t) {
            $realisasi_sebelumnya[$t->id_target] = DB::table('tb_realisasi')
            ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
            ->where('tb_rtarget.id_target', $t->id_target)
            ->where('id_bulan', '<', $select_bulan)
            ->where('status_realisasi', '1')
            ->sum('pagu_realisasi');
        }

        $realisasi_sekarang = array();
        foreach ($target as $t) {
            $realisasi_sekarang[$t->id_target] = DB::table('tb_realisasi')
            ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
            ->where('tb_rtarget.id_target', $t->id_target)
            ->where('id_bulan', '<=', $select_bulan)
            ->where('status_realisasi', '1')
            ->sum('pagu_realisasi');
        }

        } else {
            $pilih_bulan = [];
            $target = [];
            $realisasi_bulan = [];
            $realisasi_sebelumnya = [];
            $realisasi_sekarang = [];
        }

        return view('admin.realisasi.view', compact('bulan', 'pilih_bulan', 'target', 'realisasi_bulan', 'realisasi_sebelumnya', 'realisasi_sekarang'));
    }

    public function adm_rview($id_target, $id_bulan){

        $id_bulan = Crypt::decrypt($id_bulan);
        $id_target = Crypt::decrypt($id_target);

        $filter = DB::table('tb_bulan')
        ->where('id_bulan', $id_bulan)
        ->first();

        $agency = DB::table('tb_target')
        ->leftJoin('tb_agency', 'tb_target.id_agency', '=', 'tb_agency.id_agency')
        ->select('tb_target.*', 'tb_agency.nama_agency')
        ->where('id_target', $id_target)
        ->first();

        // Menampilkan Data Rincian Realisasi Anggaran Murni
        $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->leftJoin('tb_realisasi', function ($join) use ($id_bulan) {
                $join->on('tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
                    ->where('tb_realisasi.id_bulan', $id_bulan);
            })
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
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan < ' . $id_bulan . ') as pagu_realisasi_sebelumnya'),
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $id_bulan . ') as pagu_realisasi_sekarang')
            )
            ->where('id_target', $id_target)
            ->where('status_rtarget', '0')
            ->orderBy('kode_ojk', 'ASC')
            ->get()
            ->groupBy('kode_jr')
            ->map(function($item, $key) {
                return $item->groupBy('kode_sr')
                    ->map(function($item, $key) {
                        return $item->groupBy('kode_ojk');
                    });
            });

        return view('admin.realisasi.rview', compact('rincian', 'filter', 'agency'));

    }


}
