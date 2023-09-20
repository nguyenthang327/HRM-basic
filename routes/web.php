<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('/company')->group(function(){
    Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
});

Route::prefix('/department')->group(function(){
    Route::get('/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
});

Route::prefix('/group')->group(function(){
    Route::get('/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/store', [GroupController::class, 'store'])->name('group.store');
    Route::get('/edit/{id}', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/update/{id}', [GroupController::class, 'update'])->name('group.update');
});

Route::get('get-department-by-company', [CompanyController::class, 'getDepartmentByCompany'])->name('getDepartmentByCompany');
Route::get('get-group-by-department', [CompanyController::class, 'getGroupByDepartment'])->name('getGroupByDepartment');


