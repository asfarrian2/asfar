<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ObjekretribusiController extends Controller
{
    public function view(){
        $view = DB::table('tb_ojkretribusi')
        ->leftJoin('tb_subretribusi', 'tb_ojkretribusi.id_js', '=', 'tb_ojkretribusi.id_js')
        ->leftJoin('tb_jenretribusi', 'tb_subretribusi.id_jr', '=', 'tb_jenretribusi.id_jr')
        ->select('tb_ojkretribusi.*', 'tb_jenretribusi.*', 'tb_subretribusi.*')
        ->get();

        $jenis = DB::table('tb_jenretribusi')
        ->where('status_jr', '1')
        ->get();

        return view('admin.objekretribusi.view', compact('view', 'jenis'));
    }
}
