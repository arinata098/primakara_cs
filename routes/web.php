<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChecklistController;
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
    // checkList
    Route::get('/checklist', [ChecklistController::class, 'index'])->middleware('auth')->name('checklist');
    Route::post('/storeCheckList', [ChecklistController::class, 'store'])->middleware('auth')->name('insert.checklist');
    Route::get('/editCheckList/{id}', [ChecklistController::class, 'edit'])->middleware('auth')->name('edit.checklist');
    Route::post('/updateCheckList/{id}', [ChecklistController::class, 'update'])->middleware('auth')->name('update.checklist');
    Route::delete('/deleteCheckList/{id}', [ChecklistController::class, 'destroy'])->middleware('auth')->name('destroy.checklist');

});

Route::get('/userDashboard', [UserController::class, 'index'])->middleware('auth')->name('userDashboard');










