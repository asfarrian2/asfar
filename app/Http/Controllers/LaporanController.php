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

use function Laravel\Prompts\select;

class LaporanController extends Controller
{
    public function laporan_realisasi(){

        $id_tahun = Auth::guard('operator')->user()->id_tahun;
        $id_agency = Auth::guard('operator')->user()->id_agency;

        //Cek Data Target
        $cektarget = DB::table('tb_target')
        ->where('id_tahun', $id_tahun)
        ->where('id_agency', $id_agency)
        ->get();

        $bulan = DB::table('tb_bulan')
        ->Where('id_tahun', $id_tahun)
        ->get();

        return view ('operator.laporan.realisasi.menu', compact('bulan'));
    }


    public function cetak_realisasi(Request $request){

        $id_agency = Auth::guard('operator')->user()->id_agency;
        $id_tahun = Auth::guard('operator')->user()->id_tahun;
        $id_bulan = $request->bulan;
        $id_bulan = Crypt::decrypt($id_bulan);

        $bulan = DB::table('tb_bulan')
        ->where('id_bulan', $id_bulan)
        ->first();

        $agency = DB::table('tb_agency')
        ->where('id_agency', $id_agency)
        ->first();

        $target = DB::table('tb_target')
        ->where('id_tahun', $id_tahun)
        ->where('id_agency', $id_agency)
        ->first();

        $id_target = $target->id_target;

        $tipe_bulan = $bulan->tipe_bulan;

        if ($id_bulan){

            if ($tipe_bulan == 1){
            // Menampilkan Data Rincian Realisasi Anggaran Murni
            $rincian = DB::table('tb_rtarget')
            ->leftJoin('tb_ojkretribusi', 'tb_rtarget.id_ojk', '=', 'tb_ojkretribusi.id_ojk')
            ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_sr', '=', 'tb_subretribusi.id_sr')
            ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
            ->leftJoin('tb_realisasi', function ($join) use ($id_bulan) {
                $join->on('tb_rtarget.id_rtarget', '=', 'tb_realisasi.id_rtarget')
                    ->where('tb_realisasi.id_bulan', $id_bulan);
            })
            ->select(
                'tb_rtarget.*',
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
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $id_bulan . ') as pagu_realisasi_sekarang'),
                DB::raw('( ROUND(( (SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $id_bulan . ') / pagu_rtarget ) * 100, 2) ) as persen_realisasi')
            )
            ->where('id_target', $id_target)
            ->where('status_rtarget', '0')
            ->orderBy('kode_ojk', 'ASC')
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
                DB::raw('(SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $id_bulan . ') as pagu_realisasi_sekarang'),
                DB::raw('( ROUND(( (SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND id_bulan <= ' . $id_bulan . ') / pagu_prtarget ) * 100, 2) ) as persen_realisasi')
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

            $jumlah = DB::table('tb_rtarget')
            ->where('id_target',$id_target)
            ->sum('pagu_prtarget');
            } //endif


        $count = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->leftJoin('tb_target', 'tb_rtarget.id_target', '=', 'tb_target.id_target')
        ->select('tb_realisasi.*', 'tb_rtarget.id_rtarget', 'tb_target.id_target')
        ->where('id_bulan', $id_bulan)
        ->where('tb_target.id_target',$id_target)
        ->where('status_realisasi', '1')
        ->count();

        //

        $total = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', $id_bulan)
        ->sum('pagu_realisasi');

        $total_sebelumnya = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<' , $id_bulan)
        ->sum('pagu_realisasi');

        $total_sekarang = DB::table('tb_realisasi')
        ->leftJoin('tb_rtarget', 'tb_realisasi.id_rtarget', '=', 'tb_rtarget.id_rtarget')
        ->select('tb_realisasi.*', 'tb_rtarget.id_target')
        ->where('id_target',$id_target)
        ->where('id_bulan', '<=' , $id_bulan)
        ->sum('pagu_realisasi');

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Realisasi Peneriman Retribusi $bulan->nama_bulan.xls");
            return view('operator.laporan.realisasi.cetak', compact('rincian', 'target', 'jumlah', 'total', 'bulan', 'count', 'total_sebelumnya', 'total_sekarang', 'agency'));
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('F4', 'landscape', 'auto');
        $pdf->loadView('operator.laporan.realisasi.cetak', compact('rincian', 'target', 'jumlah', 'total', 'bulan', 'count', 'total_sebelumnya', 'total_sekarang', 'agency'));

        return $pdf->download('Laporan Realisasi Peneriman Retribusi '.$bulan->nama_bulan.'.pdf');

    }
    return view ('operator.laporan.realisasi.cetak', compact('bulan'));
    }

        public function laporan_evaluasi(){

        $id_tahun = Auth::guard('operator')->user()->id_tahun;
        $id_agency = Auth::guard('operator')->user()->id_agency;

        //Cek Data Target
        $cektarget = DB::table('tb_target')
        ->where('id_tahun', $id_tahun)
        ->where('id_agency', $id_agency)
        ->get();

        $triwulan = DB::table('tb_triwulan')
        ->Where('id_tahun', $id_tahun)
        ->get();

        return view ('operator.laporan.evaluasi.menu', compact('triwulan'));
    }

    public function cetak_evaluasi(Request $request){

        $id_agency = Auth::guard('operator')->user()->id_agency;
        $id_tahun = Auth::guard('operator')->user()->id_tahun;
        $id_triwulan = $request->triwulan;
        $id_triwulan = Crypt::decrypt($id_triwulan);

        $agency = DB::table('tb_agency')
        ->where('id_agency', $id_agency)
        ->first();

        $target = DB::table('tb_target')
        ->where('id_tahun', $id_tahun)
        ->where('id_agency', $id_agency)
        ->first();

        $evaluasi = DB::table('tb_evaluasi')
        ->where('id_agency', $id_agency)
        ->where('id_triwulan', $id_triwulan)
        ->first();

        $id_target = $target->id_target;

        if ($id_triwulan){

            $triwulan = DB::table('tb_triwulan')
            ->where('id_triwulan', $id_triwulan)
            ->first();

            $nilai_triwulan = $triwulan->nilai_triwulan;

            if ($nilai_triwulan <4) {
                $id_bulan = $id_tahun.'01';
            }else{
                   $id_bulan = $id_tahun.'10';
            }

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
                DB::raw('( ROUND(( (SELECT SUM(pagu_realisasi) FROM tb_realisasi WHERE id_rtarget = tb_rtarget.id_rtarget AND tb_bulan.nilaiy_bulan <= ' . $nilai_triwulan . ') / pagu_rtarget ) * 100, 2) ) as persen_realisasi'),


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

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Realisasi Peneriman Retribusi.xls");
            return view('operator.laporan.evaluasi.cetak', compact('rincian', 'evaluasi', 'nilai_triwulan', 'target', 'jumlah', 'total', 'count', 'total_tw1', 'total_tw2', 'total_tw3', 'total_tw4', 'total_sekarang', 'agency', 'triwulan'));
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('F4', 'landscape', 'auto');
        $pdf->loadView('operator.laporan.evaluasi.cetak', compact('rincian', 'evaluasi', 'nilai_triwulan', 'target', 'jumlah', 'total', 'count', 'total_tw1', 'total_tw2', 'total_tw3', 'total_tw4', 'total_sekarang', 'agency', 'triwulan'));

        return $pdf->download('Laporan Realisasi Peneriman Retribusi.pdf');

    }
    return view ('operator.laporan.realisasi.cetak', compact('bulan'));
    }


    public function adm_laporan_target(){

        $id_tahun = Auth::guard('admin')->user()->id_tahun;

        $bulan = DB::table('tb_bulan')
        ->Where('id_tahun', $id_tahun)
        ->get();

        return view ('admin.laporan.target.menu', compact('bulan'));
    }

    public function adm_cetak_target(Request $request){

        $jenis = $request->jenis;
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $view = DB::table('tb_agency')
        ->get();

        $target = DB::table('tb_target')
        ->where('id_tahun', $tahun_sekarang)
        ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'potraid', 'auto');

        //Cetak Semua Jenis Target
        if ($jenis == 0) {
            if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Target Peneriman Retribusi.xls");
            return view('admin.laporan.target.csemua', compact('tahun_sekarang', 'view', 'target'));
            }

            $pdf->loadView('admin.laporan.target.csemua', compact('tahun_sekarang', 'view', 'target'));
            return $pdf->download('Laporan Target Peneriman Retribusi '.$tahun_sekarang.'.pdf');
         }

        if ($jenis == 1) {
            if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Target APBD Peneriman Retribusi.xls");
            return view('admin.laporan.target.capbd', compact('tahun_sekarang', 'view', 'target'));
            }

            $pdf->loadView('admin.laporan.target.capbd', compact('tahun_sekarang', 'view', 'target'));
            return $pdf->download('Laporan Target Peneriman Retribusi APBD '.$tahun_sekarang.'.pdf');
        }
        if ($jenis == 2) {

            if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Target APBDP Peneriman Retribusi.xls");
            return view('admin.laporan.target.capbdp', compact('tahun_sekarang', 'view', 'target'));
            }

             $pdf->loadView('admin.laporan.target.capbdp', compact('tahun_sekarang', 'view', 'target'));
            return $pdf->download('Laporan Target Peneriman Retribusi APBD Perubahan '.$tahun_sekarang.'.pdf');
        }else{
            return view ('admin.laporan.target.csemua', compact('tahun_sekarang', 'view', 'target'));
        }


    }

    public function adm_laporan_realisasi(){

        $id_tahun = Auth::guard('admin')->user()->id_tahun;

        $bulan = DB::table('tb_bulan')
        ->Where('id_tahun', $id_tahun)
        ->get();

        return view ('admin.laporan.realisasi.menu', compact('bulan'));
    }

    public function adm_cetak_realisasi(Request $request){

        //Menampilkan Data Utama Target
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $select_bulan      = $request->bulan;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'potraid', 'auto');

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

         $pdf->loadView('admin.laporan.realisasi.cetak', compact('pilih_bulan', 'target', 'realisasi_bulan', 'realisasi_sebelumnya', 'realisasi_sekarang'));
        return $pdf->download('Laporan Realisasi Peneriman Retribusi APBD Perubahan '.$tahun_sekarang.' '.$pilih_bulan->nama_bulan.'.pdf');
    }

        public function adm_laporan_skpd(){

        $id_tahun = Auth::guard('admin')->user()->id_tahun;

        $bulan = DB::table('tb_bulan')
        ->Where('id_tahun', $id_tahun)
        ->get();

        $agency = DB::table('tb_target')
        ->leftJoin('tb_agency', 'tb_target.id_agency', '=', 'tb_agency.id_agency')
        ->select('tb_target.*', 'tb_agency.id_agency', 'tb_agency.nama_agency')
        ->where('id_tahun', $id_tahun)
        ->get();

        return view ('admin.laporan.skpd.menu', compact('bulan', 'agency'));
    }

    public function adm_cetak_skpd(Request $request){

        //Menampilkan Data Utama Target
        $tahun_sekarang   = Auth::guard('admin')->user()->id_tahun;

        $select_bulan      = $request->bulan;
        $select_target     = $request->target;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape', 'auto');

        if ($select_bulan) {
        $id_bulan = Crypt::decrypt($select_bulan);
        $id_target = Crypt::decrypt($select_target);

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

        } else {
            $filter = [];
        }

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Realisasi Peneriman Retribusi $filter->nama_bulan.xls");
            return view('admin.laporan.skpd.cetak', compact('rincian', 'filter', 'agency'));
        }

         $pdf->loadView('admin.laporan.skpd.cetak', compact('rincian', 'filter', 'agency'));
        return $pdf->download('Laporan Realisasi Peneriman Retribusi APBD Perubahan '.$tahun_sekarang.' '.$filter->nama_bulan.'.pdf');


    }




}
