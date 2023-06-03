<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LabellingController;
use App\Http\Controllers\PreprocessingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BerandaController::class, 'index'])->name('index');
Route::get('/import', [ImportController::class, 'index']);
Route::post('/import/upload', [ImportController::class, 'upload'])->name('uploaddata');
Route::post('/import/delete', [ImportController::class, 'deleteData'])->name('deletedata');
Route::get('/preprocessing', [PreprocessingController::class, 'index']);
Route::post('/preprocessing/start', [PreprocessingController::class, 'startPreprocessing'])->name('startPreprocessing');
Route::get('/labelling', [LabellingController::class, 'index']);
