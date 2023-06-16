<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LabellingController;
use App\Http\Controllers\ModellingController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\PreprocessingController;
use App\Http\Controllers\SplitController;
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
Route::post('/preprocessing/delete', [PreprocessingController::class, 'deletePreprocessing'])->name('deletePreprocessing');

Route::get('/labelling', [LabellingController::class, 'index']);
Route::post('/labelling/start', [LabellingController::class, 'startLabelling'])->name('startLabelling');
Route::post('/labelling/update', [LabellingController::class, 'updateLabelling'])->name('updateLabelling');

Route::get('/split', [SplitController::class, 'index']);
Route::post('/split/start', [SplitController::class, 'startSplit'])->name('startSplit');
Route::post('/split/delete', [SplitController::class, 'deleteData'])->name('deleteSplit');

Route::get('/modelling', [ModellingController::class, 'index']);
Route::post('/modelling/start', [ModellingController::class, 'startModelling'])->name('startModelling');
Route::post('/modelling/delete', [ModellingController::class, 'deleteModel']);

Route::get('/pengujian', [PengujianController::class, 'index']);
Route::post('/pengujian/start', [PengujianController::class, 'startTesting'])->name('startPengujian');
