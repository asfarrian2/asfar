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
        $menu = DB::table('tb_tahun')
        ->get();

        return view('admin.menu.anggaran.view', compact('menu'));
    }

    public function store(Request $request){

        $id_tahun = $request->tahun;

         //Validasi Tahun
         $cekkode = DB::table('tb_tahun')
         ->where('id_tahun', '=', $id_tahun)
         ->count();

          if ($cekkode > 0) {
         return Redirect::back()->with(['warning' => 'Tahun Anggaran Sudah Digunakan']);
          }else{
            $tahun = [
                'id_tahun'         => $id_tahun,
                'apbd_tahun'       => '1',
                'apbdp_tahun'      => '0',
                'status_tahun'      => '1'

            ];

            $januari = [
                'id_bulan'      => 'b01'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'   => 'Januari',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '1',
                'nilaiy_bulan'      => '1'

            ];
            $februari = [
                'id_bulan'         => 'b02'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'       => 'Februari',
                'tipe_bulan'       => '1',
                'status_bulan'     => '0',
                'nilaix_bulan'     => '2',
                'nilaiy_bulan'     => '1'

            ];
            $maret = [
                'id_bulan'         => 'b03'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Maret',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '3',
                'nilaiy_bulan'      => '1'
            ];
            $april = [
                'id_bulan'         => 'b04'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'April',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '4',
                'nilaiy_bulan'      => '2'
            ];
            $mei = [
                'id_bulan'         => 'b05'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Mei',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '5',
                'nilaiy_bulan'      => '2'
            ];
            $juni = [
                'id_bulan'         => 'b06'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Juni',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '6',
                'nilaiy_bulan'      => '2'
            ];
            $juli = [
                'id_bulan'         => 'b07'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Juli',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '7',
                'nilaiy_bulan'      => '3'
            ];
            $agustus = [
                'id_bulan'         => 'b08'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Agustus',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '8',
                'nilaiy_bulan'      => '3'
            ];
            $september = [
                'id_bulan'         => 'b09'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'September',
                'tipe_bulan'   => '1',
                'status_bulan' => '0',
                'nilaix_bulan'      => '9',
                'nilaiy_bulan'      => '3'
            ];
            $oktober = [
                'id_bulan'         => 'b10'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Oktober',
                'tipe_bulan'   => '2',
                'status_bulan' => '0',
                'nilaix_bulan'      => '10',
                'nilaiy_bulan'      => '4'
            ];
            $november = [
                'id_bulan'         => 'b11'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'November',
                'tipe_bulan'   => '2',
                'status_bulan' => '0',
                'nilaix_bulan'      => '11',
                'nilaiy_bulan'      => '4'
            ];
            $desember = [
                'id_bulan'         => 'b12'.$id_tahun,
                'id_tahun'         => $id_tahun,
                'nama_bulan'     => 'Desember',
                'tipe_bulan'   => '2',
                'status_bulan' => '0',
                'nilaix_bulan'      => '12',
                'nilaiy_bulan'      => '4'
            ];
            $data = [
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
            $simpan = DB::table('tb_tahun')->insert($tahun);
            if ($simpan) {
                DB::table('tb_bulan')->insert($data);
                return Redirect('/admin/menuanggaran')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
            }

          }
    }

    //Status Data
    public function status($id_menu)
    {
        $id_menu   = Crypt::decrypt($id_menu);

        $data = DB::table('tb_menu')
        ->where('id_menu', $id_menu)
        ->first();

        $status_menu = $data->status_menu;

        $aktif = [
            'status_menu' => '1',
        ];

        $nonaktif = [
            'status_menu' => '0',
        ];

        if($status_menu == '0'){
            $update = DB::table('tb_menu')->where('id_menu', $id_menu)->update($aktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Diaktifkan.']);
            }

        }else{
            $update = DB::table('tb_menu')->where('id_menu', $id_menu)->update($nonaktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dinonaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dinonaktifkan.']);
            }
            }

    }

    //Hapus Data
     public function delate($id_tahun)
     {
        $id = Crypt::decrypt($id_tahun);

        $id_tahun = DB::table('tb_tahun')
        ->where('id_tahun',$id)
        ->first();

        $cek = DB::table('tb_target')
        ->where('id_tahun', $id)
        ->count();

        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Tahun Anggaran Telah Digunakan, Data Tidak Dapat Dihapus']);
        }else{
            $delete = DB::table('tb_tahun')->where('id_tahun', $id)->delete();
            if ($delete) {
                DB::table('tb_bulan')->where('id_tahun', $id)->delete();
                return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
            }
        }
     }

     public function view_r($id_tahun){
        $id = Crypt::decrypt($id_tahun);

        $menu = DB::table('tb_bulan')
        ->where('id_tahun', $id)
        ->get();

        return view('admin.menu.bulan.view', compact('id', 'menu'));
    }

        //Status Data
    public function bulan($id_bulan)
    {
        $id_bulan   = Crypt::decrypt($id_bulan);

        $data = DB::table('tb_bulan')
        ->where('id_bulan', $id_bulan)
        ->first();

        $status_bulan = $data->status_bulan;

        $aktif = [
            'status_bulan' => '1',
        ];

        $nonaktif = [
            'status_bulan' => '0',
        ];

        if($status_bulan == '0'){
            $update = DB::table('tb_bulan')->where('id_bulan', $id_bulan)->update($aktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Diaktifkan.']);
            }

        }else{
            $update = DB::table('tb_bulan')->where('id_bulan', $id_bulan)->update($nonaktif);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dinonaktifkan.']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dinonaktifkan.']);
            }
            }

    }



}
