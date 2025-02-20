<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//REST API
Route::get('/allpatient', [PatientController::class, 'fetchpatients']);
Route::post('/addpatient', [PatientController::class, 'addpatient']);
Route::get('/selectpatient/{id}', [PatientController::class, 'findpatient']);
Route::get('/searchpatient', [PatientController::class, 'searchpatient']);
Route::put('/patient/*', [PatientController::class, 'softDeletePatient']);
Route::put('/patient/{id}/delete', [PatientController::class, 'softDeletePatient']);
Route::put('/editpatient/*', [PatientController::class, 'updatePatient']);
Route::put('/editpatient/{id}', [PatientController::class, 'updatePatient']);