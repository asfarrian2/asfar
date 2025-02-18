<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

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
