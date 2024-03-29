<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPortsController;
use App\Http\Controllers\OltController;
use App\Http\Controllers\OltPortController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\StoController;
use App\Http\Controllers\UserController;
use App\Models\Slot;
use GuzzleHttp\Middleware;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [PengajuanController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('olt', [OltController::class, 'index'])->name('olt.index');
    Route::get('olt/detail/{olt}/slot/{slot?}', [OltController::class, 'detail'])->name('olt.show');
    // Route::get('olt/detail/{olt}/slot/{slot}', [::class, 'detail'])->name('olt.showPort');

    Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('pengajuan/exportPDF/{pengajuan}', [PengajuanController::class, 'exportPdf'])->name('pengajuan.pdf');
    Route::post('pengajuan/port', [PengajuanController::class, 'pengajuanPort'])->name('pengajuan.port');
});
Route::middleware('asmen')->group(function () {

    /*========================================== MANAGEMENT USERS ========================================== */
    Route::get('user/waspang', [UserController::class, 'waspangIndex'])->name('waspang.index');
    Route::get('user/asmen', [UserController::class, 'asmenIndex'])->name('asmen.index');
    Route::post('user/waspang/store', [UserController::class, 'waspangStore'])->name('waspang.store');
    Route::post('user/asmen/store', [UserController::class, 'asmenStore'])->name('asmen.store');
    Route::delete('user/waspang/{user:username}', [UserController::class, 'waspangDestroy'])->name('waspang.destroy');
    Route::delete('user/asmen/{user:username}', [UserController::class, 'asmenDestroy'])->name('asmen.destroy');

    /* =========================================== MANAGEMENT OLT ===========================================*/
    Route::post('olt/store', [OltController::class, 'store'])->name('olt.store');
    Route::delete('olt/delete/{olt}', [OltController::class, 'destroy'])->name('olt.destroy');
    Route::post('olt/import', [OltController::class, 'import'])->name('olt.import');
    Route::get('persetujuan', [PengajuanController::class, 'index'])->name('pengajuan.persetujuan');
    Route::put('persetujuan/diterima/{pengajuan}', [PengajuanController::class, 'diterima'])->name('pengajuan.diterima');
    Route::put('persetujuan/ditolak/{pengajuan}', [PengajuanController::class, 'ditolak'])->name('pengajuan.ditolak');

    /* ======================================== MANAGEMENT OLT-PORT ========================================*/
    Route::put('olt/port/{port}', [OltPortController::class, 'edit'])->name('port.edit');
    Route::post('olt/port/{slot}', [OltPortController::class, 'addPort'])->name('port.addPort');
    Route::get('olt/port/{port}', [OltPortController::class, 'detail'])->name('port.detail');
    Route::put('olt/port/unabel/{port}', [OltPortController::class, 'unable'])->name('port.unable');
    // Route::put('olt/port/{port}', [OltPortController::class, 'edit'])->name('port.edit');

    /* =========================================== MANAGEMENT STO ==========================================*/
    Route::get('sto', [StoController::class, 'index'])->name('sto.index');
    Route::post('sto/import', [StoController::class, 'import'])->name('sto.import');

    /* =========================================== MANAGEMENT SLOT ==========================================*/
    Route::post('olt/slot', [SlotController::class, 'store'])->name('slot.store');
    Route::get('olt/slot/{slot}', [SlotController::class, 'edit'])->name('slot.edit');
    Route::put('olt/slot/update/{slot}', [SlotController::class, 'update'])->name('slot.update');
});
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login/authentication', [AuthController::class, 'authenticate'])->name('login.authentication');
});
