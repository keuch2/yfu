<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pipeline/{type}/{stage}', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::post('/pipeline/{type}/{stage}', [PipelineController::class, 'store'])->name('pipeline.store');
    Route::put('/pipeline/{type}/{stage}/{person}', [PipelineController::class, 'update'])->name('pipeline.update');
    Route::delete('/pipeline/{type}/{stage}/{person}', [PipelineController::class, 'destroy'])
        ->name('pipeline.destroy')->middleware('role:super_admin,admin');
    Route::post('/pipeline/{type}/{stage}/{person}/convert', [PipelineController::class, 'convert'])
        ->name('pipeline.convert')->middleware('role:super_admin,admin');

    Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store')
        ->middleware('role:super_admin,admin');
    Route::put('/families/{family}', [FamilyController::class, 'update'])->name('families.update')
        ->middleware('role:super_admin,admin');
    Route::delete('/families/{family}', [FamilyController::class, 'destroy'])->name('families.destroy')
        ->middleware('role:super_admin,admin');

    Route::get('/coordinators', [CoordinatorController::class, 'index'])->name('coordinators.index');
    Route::post('/coordinators', [CoordinatorController::class, 'store'])->name('coordinators.store')
        ->middleware('role:super_admin,admin');
    Route::put('/coordinators/{coordinator}', [CoordinatorController::class, 'update'])->name('coordinators.update')
        ->middleware('role:super_admin,admin');
    Route::delete('/coordinators/{coordinator}', [CoordinatorController::class, 'destroy'])->name('coordinators.destroy')
        ->middleware('role:super_admin,admin');

    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/export', [ExportController::class, 'index'])->name('export.index');
        Route::get('/export/json', [ExportController::class, 'json'])->name('export.json');
        Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
    });

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
