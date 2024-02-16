<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardKonsumenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Location\GarduIndukController;
use App\Http\Controllers\Location\IndukController;
use App\Http\Controllers\Location\UnitLayananController;
use App\Http\Controllers\Location\UnitPelayananController;
use App\Http\Controllers\Master\CuacaBmkgController;
use App\Http\Controllers\Master\FungsiController;
use App\Http\Controllers\Master\JenisGangguanController;
use App\Http\Controllers\Master\KategoriPenyebabGangguanController;
use App\Http\Controllers\Master\KonsumenKttController;
use App\Http\Controllers\Master\LokasiController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\SubsystemController;
use App\Http\Controllers\Master\TeganganController;
use App\Http\Controllers\Master\TipeGangguanController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Transaksi\GangguanController;
use App\Http\Controllers\Transaksi\InvestigasiController;
use App\Http\Controllers\Transaksi\JalurController;
use App\Http\Controllers\Transaksi\PqmController;
use App\Http\Controllers\Transaksi\TindaklanjutController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index']);

// Route::get('/', function () {
//     return view('auth.login');
// });

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function () {
    // Dasboard
    Route::get('/dashboard_konsumen', [DashboardKonsumenController::class, 'index'])->name('dashboard_konsumen');
    Route::post('/showInfoChart', [DashboardKonsumenController::class, 'showInfoChart'])->name('showInfoChart');
    Route::post('/showDataDashboardGangguan', [DashboardKonsumenController::class, 'showDataGangguan'])->name('showDataDashboardGangguan');
    Route::post('/showDataDashboardJalur', [DashboardKonsumenController::class, 'showDatajalur'])->name('showDataDashboardJalur');
    Route::post('/showDataGangguanByCategories', [HomeController::class, 'showDataGangguanByCategories'])->name('showDataGangguanByCategories');
    Route::post('/showDataChartRekapGangguanByCategories', [HomeController::class, 'showDataChartRekapGangguanByCategories'])->name('showDataChartRekapGangguanByCategories');


    // settings
    Route::resource('roles', RoleController::class);
    Route::resource('permisions', PermissionController::class);
    Route::resource('users', UserController::class);

    // Lokasi
    Route::resource('induks', IndukController::class)->except('show');
    Route::resource('unitPelayanan', UnitPelayananController::class)->except('show');
    Route::resource('unitLayanan', UnitLayananController::class)->except('show');
    Route::resource('garduInduk', GarduIndukController::class)->except('show');

    // master
    Route::resource('status', StatusController::class)->except('show');
    Route::resource('fungsi', FungsiController::class)->except('show');
    Route::resource('tegangan', TeganganController::class)->except('show');
    Route::resource('lokasi', LokasiController::class)->except('show');
    Route::resource('cuaca', CuacaBmkgController::class)->except('show');
    Route::resource('konsumen', KonsumenKttController::class)->except('show');
    Route::resource('jenisGangguan', JenisGangguanController::class)->except('show');
    Route::resource('tipeGangguan', TipeGangguanController::class)->except('show');
    Route::resource('kategoriGangguan', KategoriPenyebabGangguanController::class)->except('show');
    Route::resource('investigasi', InvestigasiController::class)->except(['show', 'index', 'create', 'store', 'delete']);
    Route::resource('tindaklanjut', TindaklanjutController::class)->except('show');
    Route::resource('island', SubsystemController::class);
    Route::get('/getLocations', [SubsystemController::class, 'getLocations'])->name('island.getLocations');
    Route::post('/showDataSubstation', [SubsystemController::class, 'showDataSubstation'])->name('island.showDataSubstation');
    Route::post('listForm', [KonsumenKttController::class, 'listForm'])->name('list_form');

    // transaksi
    Route::resource('pqm', PqmController::class)->except('show');
    Route::resource('jalur', JalurController::class)->except('show');
    Route::resource('gangguan', GangguanController::class);
    Route::post('/showDataGangguan', [GangguanController::class, 'showDataGangguan'])->name('gangguan.showDataGangguan');
});

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'], function () {
    return abort(404);
});

Route::get('/oauth/redirect/pln', [App\Http\Controllers\IamController::class, 'getPLNRedirect']);
Route::get('/oauth/handle/pln', [App\Http\Controllers\IamController::class, 'getPLNHandle']);
Route::get('/oauth/logout', [App\Http\Controllers\IamController::class, 'logoutSSO'])->name('logout_sso');
