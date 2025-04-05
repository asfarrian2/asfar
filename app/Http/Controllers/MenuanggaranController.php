<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class MenuanggaranController extends Controller
{
    public function view(){
        $menu = DB::table('tb_menu')
        ->where('tipe_menu', '1')
        ->get();

        return view('admin.menu.anggaran.view', compact('menu'));
    }

    public function store(Request $request){

        $uraian_menu = $request->tahun;

         //Validasi Tahun
         $cekkode = DB::table('tb_menu')
         ->where('uraian_menu', '=', $uraian_menu)
         ->count();

          if ($cekkode > 0) {
         return Redirect::back()->with(['warning' => 'Tahun Anggaran Sudah Digunakan']);
          }else{
            $apbd = [
                'id_menu'         => 'tm'.$uraian_menu,
                'uraian_menu'     => $uraian_menu,
                'tipe_menu'       => '1',
                'keterangan_menu' => '1',
                'status_menu'     => '1'

            ];
            $apbdp = [
                'id_menu'         => 'tp'.$uraian_menu,
                'uraian_menu'     => $uraian_menu,
                'tipe_menu'       => '1',
                'keterangan_menu' => '2',
                'status_menu'     => '0'

            ];

            $januari = [
                'id_menu'         => 'b01'.$uraian_menu,
                'uraian_menu'     => 'Januari',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'

            ];
            $februari = [
                'id_menu'         => 'b02'.$uraian_menu,
                'uraian_menu'     => 'Februari',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $maret = [
                'id_menu'         => 'b03'.$uraian_menu,
                'uraian_menu'     => 'Maret',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $april = [
                'id_menu'         => 'b04'.$uraian_menu,
                'uraian_menu'     => 'April',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $mei = [
                'id_menu'         => 'b05'.$uraian_menu,
                'uraian_menu'     => 'Mei',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $juni = [
                'id_menu'         => 'b06'.$uraian_menu,
                'uraian_menu'     => 'Juni',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $juli = [
                'id_menu'         => 'b07'.$uraian_menu,
                'uraian_menu'     => 'Juli',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $agustus = [
                'id_menu'         => 'b08'.$uraian_menu,
                'uraian_menu'     => 'Agustus',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $september = [
                'id_menu'         => 'b09'.$uraian_menu,
                'uraian_menu'     => 'September',
                'tipe_menu'       => '2',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $oktober = [
                'id_menu'         => 'b10'.$uraian_menu,
                'uraian_menu'     => 'Oktober',
                'tipe_menu'       => '3',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $november = [
                'id_menu'         => 'b11'.$uraian_menu,
                'uraian_menu'     => 'November',
                'tipe_menu'       => '3',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $desember = [
                'id_menu'         => 'b12'.$uraian_menu,
                'uraian_menu'     => 'Desember',
                'tipe_menu'       => '3',
                'keterangan_menu' => $uraian_menu,
                'status_menu'     => '0'
            ];
            $data = [
                $apbd,
                $apbdp,
                $januari,
                $februari,
                $maret,
                $april,
                $mei,
                $juni,
                $juli,
                $agustus,
                $september,
                $oktober,
                $november,
                $desember,
            ];
            $simpan = DB::table('tb_menu')->insert($data);
            if ($simpan) {
                return Redirect('/admin/menuanggaran')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
            }

          }
    }

}
