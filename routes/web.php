<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\ReportController;
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

Route::get('/', function () {
    return redirect()->route('access.login');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('access')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [AccessController::class, 'login'])->name('access.login');
        Route::post('act', [AccessController::class, 'login_act'])->name('access.login.act');
    });
    Route::group(['prefix' => 'profile', 'middleware' => 'userauth'], function () {
        Route::get('/', [AccessController::class, 'profile'])->name('access.profile');
        Route::post('act', [AccessController::class, 'profile_act'])->name('access.profile.act');
    });
    Route::get('logout', [AccessController::class, 'logout'])->name('access.logout');
});

Route::group(['prefix' => 'user', 'middleware' => 'userauth'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user');
    Route::post('list', [UserController::class, 'list'])->name('user.list');
    Route::group(['prefix' => 'add', 'middleware' => 'userauth'], function () {
        Route::get('/', [UserController::class, 'form'])->name('user.add');
        Route::post('act', [UserController::class, 'act'])->name('user.add.act');
    });
    Route::group(['prefix' => 'edit', 'middleware' => 'userauth'], function () {
        Route::get('/{id}', [UserController::class, 'form'])->name('user.edit');
        Route::post('act/{id}', [UserController::class, 'act'])->name('user.edit.act');
    });
    Route::get('detail/{id}', [UserController::class, 'detail'])->name('user.detail');
});


Route::group(['prefix' => 'income', 'middleware' => 'userauth'], function () {
    Route::get('/', [IncomeController::class, 'index'])->name('income');
    Route::post('list', [IncomeController::class, 'list'])->name('income.list');
    Route::group(['prefix' => 'add', 'middleware' => 'userauth'], function () {
        Route::get('/', [IncomeController::class, 'form'])->name('income.add');
        Route::post('act', [IncomeController::class, 'act'])->name('income.add.act');
    });
    // Route::group(['prefix' => 'edit', 'middleware' => 'userauth'], function () {
    //     Route::get('/{id}', [IncomeController::class, 'form'])->name('income.edit');
    //     Route::post('act/{id}', [IncomeController::class, 'act'])->name('income.edit.act');
    // });
    Route::get('detail/{id}', [IncomeController::class, 'detail'])->name('income.detail');
});

Route::group(['prefix' => 'expenditure', 'middleware' => 'userauth'], function () {
    Route::get('/', [ExpenditureController::class, 'index'])->name('expenditure');
    Route::post('list', [ExpenditureController::class, 'list'])->name('expenditure.list');
    Route::group(['prefix' => 'add', 'middleware' => 'userauth'], function () {
        Route::get('/', [ExpenditureController::class, 'form'])->name('expenditure.add');
        Route::post('act', [ExpenditureController::class, 'act'])->name('expenditure.add.act');
    });
    Route::get('detail/{id}', [ExpenditureController::class, 'detail'])->name('expenditure.detail');
});

Route::group(['prefix' => 'report', 'middleware' => 'userauth'], function () {
    Route::get('/', [ReportController::class, 'index'])->name('report');
    Route::post('list', [ReportController::class, 'list'])->name('report.list');
    Route::get('detail/{id}', [ReportController::class, 'detail'])->name('report.detail');
});