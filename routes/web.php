<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InviteSquadController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\SquadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('student.auth');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/login', 'loginPage')->name('loginPage');
    Route::post('/login', 'login')->name('login');

    Route::get('/register', 'registerPage')->name('registerPage');
    Route::post('/register', 'register')->name('register');

    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('students', StudentController::class);

Route::resource('squads', SquadController::class);

Route::match(['get', 'post'], '/squads-preview', [SquadController::class, 'preview'])->name('squads.preview');

Route::post('invite/{invite}/join', [InviteSquadController::class, 'join'])->name('invite.join');
Route::resource('invite', InviteSquadController::class);
