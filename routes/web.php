<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\FilexcelsController;



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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('/user', UserController::class);

Route::get('/cetak_pdf', [App\Http\Controllers\KatalogController::class, 'cetak_pdf'])->name('cetak_pdf');

Route::resource('/katalog', KatalogController::class);

Route::get('/katalogku', [App\Http\Controllers\KatalogController::class, 'katalog'])->name('katalog');

Route::resource('/pengumuman', PengumumanController::class);

Route::get('/pengumumanku', [App\Http\Controllers\PengumumanController::class, 'pengumuman'])->name('pengumuman');

// Route::resource('/filexcel', FilexcelController::class);

// Route::get('/filexcelku', [App\Http\Controllers\FilexcelController::class, 'filexcel'])->name('filexcel');

Route::get('/filexcels', [App\Http\Controllers\FilexcelsController::class, 'index'])->name('index');

Route::post('/filexcels/import', 'FilexcelsController@import')->name('filexcels.import');

Route::post('/import', [FilexcelsController::class, 'import'])->name('filexcels.import');

Route::get('/export', [FilexcelsController::class, 'export'])->name('filexcels.export');
