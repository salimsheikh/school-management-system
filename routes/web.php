<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FeeHeadController;
use Illuminate\Support\Facades\Auth;

// Redirect `/admin` to the appropriate page
Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect().route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('login', [AdminController::class, 'index'])->name('admin.login');
        Route::get('register', [AdminController::class, 'register'])->name('admin.register');
        Route::post('authenticate',[AdminController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('logout',[AdminController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('form',[AdminController::class, 'form'])->name('admin.form');
        Route::get('table',[AdminController::class, 'table'])->name('admin.table');

        Route::resource('academic-year', AcademicYearController::class);
        Route::resource('classes', ClassesController::class);        
        Route::resource('fee-head', FeeHeadController::class);
    });
});

// Handle `/` redirection
Route::get('/', function () {    
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});







