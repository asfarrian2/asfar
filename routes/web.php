<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\HalvalidController;
use App\Http\Controllers\JenisretribusiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuanggaranController;
use App\Http\Controllers\ObjekretribusiController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\RtargetController;
use App\Http\Controllers\SubretribusiController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


//Cek Login
Route::get('/4f4adcbf8c6f66dcfc8a3282ac2bf10ac35a9fc52bb556c79f8fa540df587a2bf465b940
ae70dccf89d925c422978ba0022dc9084d59291ac6950702d30b9cdf
d259b2a4fbd8e8eeae70dccf89d925c422978ba0022dc908', [HalvalidController::class, 'ceklogin'])->name('login');

//Crud Login Admin
Route::get('/ctr_admin', [LoginController::class, 'admin']);
Route::post('/admin_login', [LoginController::class, 'admin_proses']);
Route::get('/logout', [LoginController::class, 'logout']);


Route::middleware('auth:admin')->group(function () {
//Halaman Utama Admin
Route::get('/admin/dashboardAll', [DashboardController::class, 'all']);


//Crud Data SKPD/UPTD
Route::get('/admin/agency', [AgencyController::class, 'view']);
Route::post('/admin/agency/store', [AgencyController::class, 'store']);
Route::post('/admin/agency/edit', [AgencyController::class, 'edit']);
Route::post('/admin/agency/{id_agency}/update', [AgencyController::class, 'update']);
Route::get('/admin/agency/{id_agency}/hapus', [AgencyController::class, 'delate']);

//Crud Data Operator
Route::get('/admin/operator', [OperatorController::class, 'view']);
Route::post('/admin/operator/store', [OperatorController::class, 'store']);
Route::post('/admin/operator/edit', [OperatorController::class, 'edit']);
Route::post('/admin/operator/{id_operator}/update', [OperatorController::class, 'update']);
Route::get('/admin/operator/{id_operator}/reset', [OperatorController::class, 'reset']);
Route::get('/admin/operator/{id_operator}/hapus', [OperatorController::class, 'delate']);

//Crud Data Jenis Retribusi
Route::get('/admin/jenisretribusi', [JenisretribusiController::class, 'view']);
Route::post('/admin/jenisretribusi/store', [JenisretribusiController::class, 'store']);
Route::post('/admin/jenisretribusi/edit', [JenisretribusiController::class, 'edit']);
Route::post('/admin/jenisretribusi/{id_jr}/update', [JenisretribusiController::class, 'update']);
Route::get('/admin/jenisretribusi/{id_jr}/status', [JenisretribusiController::class, 'status']);
Route::get('/admin/jenisretribusi/{id_jr}/hapus', [JenisretribusiController::class, 'delate']);

//Crud Data Sub Retribusi
Route::get('/admin/subretribusi', [SubretribusiController::class, 'view']);
Route::post('/admin/subretribusi/store', [SubretribusiController::class, 'store']);
Route::post('/admin/subretribusi/edit', [SubretribusiController::class, 'edit']);
Route::post('/admin/subretribusi/{id_sr}/update', [SubretribusiController::class, 'update']);
Route::get('/admin/subretribusi/{id_sr}/status', [SubretribusiController::class, 'status']);
Route::get('/admin/subretribusi/{id_sr}/hapus', [SubretribusiController::class, 'delate']);

//Crud Data Objek Retribusi
Route::get('/admin/objekretribusi', [ObjekretribusiController::class, 'view']);
Route::get('/admin/filtersub/{id_jr}', [ObjekretribusiController::class, 'getobjek']);
Route::post('/admin/objekretribusi/store', [ObjekretribusiController::class, 'store']);
Route::post('/admin/objekretribusi/edit', [ObjekretribusiController::class, 'edit']);

//Crud Monitoring Target APBD
Route::get('/admin/targetapbd', [TargetController::class, 'adm_view']);
Route::get('/admin/rtargetapbd/{id_target}', [TargetController::class, 'adm_rview']);

//Crud Monitoring Target APBD Perubahan
Route::get('/admin/targetapbdp', [TargetController::class, 'adm_view_p']);
Route::get('/admin/rtargetapbdp/{id_target}', [TargetController::class, 'adm_rview_p']);

//Crud Menu Anggaran
Route::get('/admin/menuanggaran', [MenuanggaranController::class, 'view']);
Route::post('/admin/menuanggaran/store', [MenuanggaranController::class, 'store']);
Route::get('/admin/menuanggaran/{id_menu}/status', [MenuanggaranController::class, 'status']);
Route::get('/admin/menuanggaran/{id_menu}/hapus', [MenuanggaranController::class, 'delate']);
Route::get('/admin/menuanggaran/{id_menu}', [MenuanggaranController::class, 'view_r']);
Route::get('/admin/menuanggaran/{id_bulan}/bulan', [MenuanggaranController::class, 'bulan']);

//Crud Menu Realisasi
Route::get('/admin/realisasi', [RealisasiController::class, 'adm_view']);
Route::get('/admin/realisasi/{id_target}/{id_bulan}', [RealisasiController::class, 'adm_rview']);

//Crud Menu Triwulan
Route::get('/admin/evaluasi', [EvaluasiController::class, 'adm_view']);
Route::get('/admin/evaluasi/{id_evaluasi}/batal', [EvaluasiController::class, 'batal']);
Route::get('/admin/evaluasi/{id_evaluasi}', [EvaluasiController::class, 'adm_rview']);

});

//Crud Login Operator
Route::get('/', [LoginController::class, 'operator']);
Route::post('/opt_login', [LoginController::class, 'operator_proses']);
Route::get('/adminlogout', [LoginController::class, 'logout_admin']);

//
Route::middleware('auth:operator')->group(function () {

// Dashboard Operator
Route::get('/opt/dashboard', [DashboardController::class, 'operator']);

// Crud Target APBD Operator
Route::get('/opt/targetapbd', [TargetController::class, 'apbd']);
Route::post('/opt/targetapbd/store', [TargetController::class, 'store']);
Route::post('/opt/targetapbd/edit', [TargetController::class, 'edit']);
Route::post('/opt/targetapbd/{id_target}/update', [TargetController::class, 'update']);
Route::get('/opt/targetapbd/{id_target}/posting', [TargetController::class, 'post']);

// Crud Rincian Target APBD Operator
Route::get('/opt/filtersub/{id_jr}', [RtargetController::class, 'getsub']);
Route::get('/opt/filterojk/{id_sr}', [RtargetController::class, 'getobjek']);
Route::post('/opt/rtargetapbd/store', [RtargetController::class, 'store']);
Route::post('/opt/rtargetapbd/edit', [RtargetController::class, 'edit']);
Route::post('/opt/rtargetapbd/{id_rtarget}/update', [RtargetController::class, 'update']);
Route::get('/opt/rtargetapbd/{id_rtarget}/hapus', [RtargetController::class, 'delate']);

// Crud Target APBD Perubahan Operator
Route::get('/opt/targetapbdp', [TargetController::class, 'apbdp']);
Route::post('/opt/targetapbdp/edit', [TargetController::class, 'edit_p']);
Route::post('/opt/targetapbdp/{id_target}/update', [TargetController::class, 'update_p']);
Route::get('/opt/targetapbdp/{id_target}/posting', [TargetController::class, 'post_p']);

// Crud Rincian Target APBD Perubahan Operator
Route::post('/opt/rtargetapbdp/store', [RtargetController::class, 'store_p']);
Route::post('/opt/rtargetapbdp/edit', [RtargetController::class, 'edit_p']);
Route::post('/opt/rtargetapbdp/{id_rtarget}/update', [RtargetController::class, 'update_p']);
Route::get('/opt/rtargetapbdp/{id_rtarget}/hapus', [RtargetController::class, 'delate_p']);

// Crud Realisasi APBD Operator
Route::get('/opt/realisasi', [RealisasiController::class, 'apbd']);
Route::post('/opt/realisasi/tambah', [RealisasiController::class, 'tambah']);
Route::post('/opt/realisasi/store', [RealisasiController::class, 'store']);
Route::post('/opt/realisasi/edit', [RealisasiController::class, 'edit']);
Route::post('/opt/realisasi/{id_realisasi}/update', [RealisasiController::class, 'update']);
Route::get('/opt/realisasi/{id_bulan}/posting', [RealisasiController::class, 'posting']);

// Crud Evaluasi
Route::get('/opt/evaluasi', [EvaluasiController::class, 'view']);
Route::post('/opt/evaluasi/store', [EvaluasiController::class, 'store']);
Route::post('/opt/evaluasi/edit', [EvaluasiController::class, 'edit']);
Route::post('/opt/evaluasi/{id_evaluasi}/update', [EvaluasiController::class, 'update']);
Route::get('/opt/evaluasi/{id_evaluasi}/posting', [EvaluasiController::class, 'post']);

// Laporan Realisasi Operator
Route::get('/opt/laporan/realisasi', [LaporanController::class, 'laporan_realisasi']);
Route::post('/opt/cetak/laporan/realisasi', [LaporanController::class, 'cetak_realisasi']);

// Laporan Evaluasi Operator
Route::get('/opt/laporan/evaluasi', [LaporanController::class, 'laporan_evaluasi']);
Route::post('/opt/cetak/laporan/evaluasi', [LaporanController::class, 'cetak_evaluasi']);


});
