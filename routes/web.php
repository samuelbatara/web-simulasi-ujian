<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticationController::class, 'index'])->name('index');


Route::get('/simpan-data', [DataController::class, 'index']);
Route::post('/simpan-data', [DataController::class, 'saveStudentsAndQuestions']);


Route::post('/masuk', [AuthenticationController::class, 'login']);
Route::post('/keluar', [AuthenticationController::class, 'logout']);

Route::get('/sebelum-ujian', [SimulationController::class, 'index'])->name('sebelum-ujian');
Route::get('/mulai-ujian/{nomorSoal}', [SimulationController::class, 'getPage']);
Route::get('/simpan-jawaban/{questionNumber}/{answer}', [SimulationController::class, 'saveAnswer']);
Route::get('/pastikan-jawaban', [SimulationController::class, 'displayAnswers']);
Route::get('/kunci-jawaban', [SimulationController::class, 'calculateScore']);

Route::get('/fitur-lainnya', [ToolController::class, 'index'])->name('fitur-lainnya');
Route::get('/download-template', [ToolController::class, 'downloadTemplate']);
Route::get('/download-report', [ToolController::class, 'downloadReport']);
Route::get('/clear-report', [ToolController::class, 'clearReport']);