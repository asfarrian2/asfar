<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;



//Halaman Utama
Route::get('/admin/dashboardAll', [DashboardController::class, 'all']);


//Crud Login
Route::get('/', [LoginController::class, 'admin'])->name('login');;
Route::post('/admin_login', [LoginController::class, 'admin_proses']);

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
