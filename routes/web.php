<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\RoomChecklistController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\SummaryController;
// User
use App\Http\Controllers\User\UserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::get('/', [LoginController::class, 'index'])->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit')->middleware('auth');
Route::patch('password', [ChangePasswordController::class, 'update'])->name('password.edit')->middleware('auth');

Route::middleware(['admin'])->group(function () {
    Route::get('/adminDashboard', [AdminController::class, 'index'])->middleware('auth')->name('adminDashboard');
    // RoomcheckList
    Route::get('/roomChecklist', [RoomChecklistController::class, 'index'])->middleware('auth')->name('roomChecklist');
    Route::get('/createRoomChecklist', [RoomChecklistController::class, 'create'])->middleware('auth')->name('create.roomChecklist');
    Route::post('/storeRoomChecklist', [RoomChecklistController::class, 'store'])->middleware('auth')->name('insert.roomChecklist');
    Route::get('/editRoomChecklist/{id}', [RoomChecklistController::class, 'edit'])->middleware('auth')->name('edit.roomChecklist');
    Route::post('/updateRoomChecklist/{id}', [RoomChecklistController::class, 'update'])->middleware('auth')->name('update.roomChecklist');
    Route::delete('/deleteRoomChecklist/{id}', [RoomChecklistController::class, 'destroy'])->middleware('auth')->name('destroy.roomChecklist');

    // checkList
    Route::get('/checklist', [ChecklistController::class, 'index'])->middleware('auth')->name('checklist');
    Route::post('/storeCheckList', [ChecklistController::class, 'store'])->middleware('auth')->name('insert.checklist');
    Route::get('/editCheckList/{id}', [ChecklistController::class, 'edit'])->middleware('auth')->name('edit.checklist');
    Route::post('/updateCheckList/{id}', [ChecklistController::class, 'update'])->middleware('auth')->name('update.checklist');
    Route::delete('/deleteCheckList/{id}', [ChecklistController::class, 'destroy'])->middleware('auth')->name('destroy.checklist');

    // Ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->middleware('auth')->name('ruangan');
    Route::post('/ruangan', [RuanganController::class, 'store'])->middleware('auth')->name('insert.ruangan');
    Route::get('/editRuangan/{id}', [RuanganController::class, 'edit'])->middleware('auth')->name('edit.ruangan');
    Route::post('/updateRuangan/{id}', [RuanganController::class, 'update'])->middleware('auth')->name('update.ruangan');
    Route::delete('/deleteRuangan/{id}', [RuanganController::class, 'destroy'])->middleware('auth')->name('destroy.ruangan');

    // User
    Route::get('/akun', [AkunController::class, 'index'])->middleware('auth')->name('akun');
    Route::post('/akun', [AkunController::class, 'store'])->middleware('auth')->name('insert.akun');
    Route::get('/editAkun/{id}', [AkunController::class, 'edit'])->middleware('auth')->name('edit.akun');
    Route::post('/updateAkun/{id}', [AkunController::class, 'update'])->middleware('auth')->name('update.akun');
    Route::delete('/deleteAkun/{id}', [AkunController::class, 'destroy'])->middleware('auth')->name('destroy.akun');
    Route::get('/resetAkun/{id}', [AkunController::class, 'reset'])->middleware('auth')->name('reset.akun');
    Route::post('/resetupdateAkun/{id}', [AkunController::class, 'resetupdate'])->middleware('auth')->name('resetupdate.akun');

    // Summary
    Route::get('/lantai', [SummaryController::class, 'index'])->middleware('auth')->name('lantai');
    Route::get('/lantaiRuangan/{id}', [SummaryController::class, 'rooms'])->middleware('auth')->name('lantaiRuangan');
    Route::get('/detailRuangan/{id}', [SummaryController::class, 'detail_ruangan'])->middleware('auth')->name('detailRuangan');
    Route::get('/listDetail/{id}', [SummaryController::class, 'list_detail'])->middleware('auth')->name('listDetail');
    Route::get('/rangkuman', [SummaryController::class, 'rangkuman'])->middleware('auth')->name('rangkuman');
    Route::get('/validasiData/{id_atribut_checklist}', [SummaryController::class, 'validasi_data'])->middleware('auth')->name('validasiData');


});

Route::get('/userDashboard', [UserController::class, 'index'])->middleware('auth')->name('userDashboard');
Route::get('/lantaiRooms/{id}', [UserController::class, 'ruangan'])->middleware('auth')->name('lantaiRooms');
Route::get('/formRuangan/{id}', [UserController::class, 'formRuangan'])->middleware('auth')->name('formRuangan');
Route::post('/storeForm', [UserController::class, 'storeForm'])->middleware('auth')->name('storeForm');











