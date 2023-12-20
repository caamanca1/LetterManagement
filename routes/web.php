<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\ResultController;
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
//     return view('login');
// })->name('login');

// Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
// Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Route::get('/error-permission', function() {
//     return view('errors.permission');
// })->name('error.permission');

// Route::middleware(['IsLogin'])->group(function() {
//     Route::get('/logout', [UserController::class, 'logout'])->name('logout');
//     Route::get('/home', function () {
//         return view('home');
//     })->name('home.page');
// });

// Route::middleware(['IsGuest'])->group(function() {
//     Route::get('/login', function () {
//         return view('login');
//     })->name('login');
//     Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
// });

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/error-permission', function() {
    return view('errors.permission');
})->name('error.permission');

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');
});

Route::middleware(['IsGuest'])->group(function() {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});

Route::middleware(['IsLogin', 'IsStaff'])->group(function() {
    // Menu Kelola Akun
    Route::prefix('/userStaff')->name('userStaff.')->group(function(){
        Route::get('/create', [UserController::class, 'Staffcreate'])->name('create');
        Route::post('/store', [UserController::class, 'Staffstore'])->name('store');
        Route::get('/', [UserController::class, 'Staffindex'])->name('home');
        Route::get('/{id}', [UserController::class, 'Staffedit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'Staffupdate'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/userGuru')->name('userGuru.')->group(function(){
        Route::get('/create', [UserController::class, 'Gurucreate'])->name('create');
        Route::post('/store', [UserController::class, 'Gurustore'])->name('store');
        Route::get('/', [UserController::class, 'Guruindex'])->name('home');
        Route::get('/{id}', [UserController::class, 'Guruedit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'Guruupdate'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/export')->name('export.')->group(function () {
        Route::get('/data', [LetterTypeController::class, 'data'])->name('data');
        Route::get('/export-excel', [LetterTypeController::class, 'fileExport'])->name('export-excel');
        Route::get('/download/{id}', [LetterTypeController::class, 'downloadPDF'])->name('download');

    });
});

Route::middleware(['IsLogin', 'IsStaff'])->group(function() {
    // Menu Kelola Surat
    Route::prefix('/KlasifikasiSurat')->name('KlasifikasiSurat.')->group(function(){
        Route::get('/create', [LetterTypeController::class, 'create'])->name('create');
        Route::post('/store', [LetterTypeController::class, 'store'])->name('store');
        Route::get('/', [LetterTypeController::class, 'index'])->name('home');
        Route::get('/{id}', [LetterTypeController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [LetterTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [LetterTypeController::class, 'destroy'])->name('delete');
    });
});