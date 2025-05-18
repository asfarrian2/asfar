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

}
