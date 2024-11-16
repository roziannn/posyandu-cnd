<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardLokasiController;

use App\Http\Controllers\DashboardPendaftaranController;
use App\Http\Controllers\DashboardAnthropometriController;
use App\Http\Controllers\DashboardPertumbuhanController;
use App\Http\Controllers\DataPertumbuhanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\main_dashboard\DashboardKadesController;
use App\Http\Controllers\main_dashboard\DashboardOrtuController;
use App\Http\Controllers\main_dashboard\DashboardPetugasController;


// landing page
Route::get('/', function () {
  return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

  Route::group(['middleware' => ['auth']], function () {

    Route::resource('/dashboard/pendaftaran', DashboardPendaftaranController::class);

    Route::get('/dashboard/hapuspendaftaran/{id}', [DashboardPendaftaranController::class, 'hapus']);
    Route::get('/dashboard/editpendaftaran/{id}', [DashboardPendaftaranController::class, 'edit']);
    Route::put('/dashboard/pendaftaran/update/{id}', [DashboardPendaftaranController::class, 'update']);
    Route::get('/dashboard/detailpendaftaran/{id}', [DashboardPendaftaranController::class, 'show']);

    Route::resource('/dashboard/lokasi-posyandu', DashboardLokasiController::class);

    Route::get('/dashboard/hapusposyandu/{id}', [DashboardLokasiController::class, 'hapusjadwal']);
    Route::get('/dashboard/editposyandu/{id}', [DashboardLokasiController::class, 'edit']);
    Route::put('/dashboard/posyandu/update/{id}', [DashboardLokasiController::class, 'update']);
    Route::get('/dashboard/detailposyandu/{id}', [DashboardLokasiController::class, 'show']);


    Route::resource('/dashboard/user', DashboardUserController::class);
    Route::get('/dashboard/hapususer/{id}', [DashboardUserController::class, 'hapususer']);
    Route::get('/dashboard/edituser/{id}', [DashboardUserController::class, 'edit']);
    Route::put('/dashboard/user/update/{id}', [DashboardUserController::class, 'update']);
    Route::get('/dashboard/detailuser/{id}', [DashboardUserController::class, 'show']);

    //Route::get('/dashboard/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');

    // revisi added 1/9/24
    Route::get('/api/pendaftaran/{nik}', [DashboardPendaftaranController::class, 'getDataByNik']);
    // revisi added 3/11/24
    Route::get('/api/pendaftaran/{nama_balita}', [DashboardPendaftaranController::class, 'getDataByName']);
  });

  Route::group(['middleware' => ['role:ortu']], function () {
    Route::get(
      '/dashboard/ortu',
      [DashboardOrtuController::class, 'index']
    )->name('dashboard.ortu');
  });


  Route::group(['middleware' => ['role:petugas']], function () {
    Route::get(
      '/dashboard/petugas',
      [DashboardPetugasController::class, 'petugas']
    )->name('dashboard.petugas');

    Route::get(
      '/dashboard/anthropometri/pertumbuhan/{id}',
      [DashboardPertumbuhanController::class, 'indexPetugas']
    )->name('pertumbuhan.petugas');

    Route::resource('pertumbuhan', DataPertumbuhanController::class);

    //  Anthropo routes

    Route::get('/dashboard/anthropometri/observasi-gizi/{id}', [DashboardAnthropometriController::class, 'observasi'])->name('anthropometri.observasi');

    Route::get('/dashboard/anthropometri/create', [DashboardAnthropometriController::class, 'create'])->name('anthropometri.create');
    Route::get('/dashboard/anthropometri/laki-laki', [DashboardAnthropometriController::class, 'indexLakiLaki'])->name('anthropometri.indexLakiLaki');
    Route::get('/dashboard/anthropometri/perempuan', [DashboardAnthropometriController::class, 'indexPerempuan'])->name('anthropometri.indexPerempuan');
    Route::post('/dashboard/anthropometri/store', [DashboardAnthropometriController::class, 'store'])->name('anthropometri.store');

    Route::get('/dashboard/anthropometri/edit/{id}', [DashboardAnthropometriController::class, 'edit'])->name('anthropometri.edit');
    Route::get('/dashboard/anthropometri/delete/{id}', [DashboardAnthropometriController::class, 'destroy'])->name('anthropometri.delete');
    Route::get('/dashboard/anthropometri/riwayat/delete/{id}', [DataPertumbuhanController::class, 'destroyRiwayat'])->name('anthropometri.deleteRiwayat');
  });

  Route::group(['middleware' => ['role:ortu']], function () {
    Route::get(
      '/dashboard/pertumbuhan',
      [DashboardPertumbuhanController::class, 'indexOrtu']
    )->name('dashboard.pertumbuhan');

    Route::get(
      '/dashboard/pertumbuhan/{id}',
      [DashboardPertumbuhanController::class, 'index']
    )->name('pertumbuhan.ortu');
  });

  Route::group(['middleware' => ['role:kades,petugas']], function () {
    Route::get(
      '/dashboard/laporan/pendaftar-posyandu',
      [LaporanController::class, 'laporanPendaftarPosyandu']
    )->name('laporan.pendaftar');
    Route::get(
      '/dashboard/kades',
      [DashboardKadesController::class, 'kades']
    )->name('dashboard.kades');

    // Excel export route
    Route::get('/pendaftaran/export-excel', [LaporanController::class, 'exportExcel'])->name('pendaftaran.export.excel');
    Route::get('/pendaftaran/export-pdf', [LaporanController::class, 'exportPdf'])->name('pendaftaran.export.pdf');
  });
});
