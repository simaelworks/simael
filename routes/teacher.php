<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\TeacherDashboardController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::middleware('teacher.guest')->group(function () {
        Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherAuthController::class, 'login']);
    });
    Route::middleware('teacher.auth')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');

        // Teacher students and squads resource routes
        Route::resource('students', App\Http\Controllers\TeacherStudentController::class);
        Route::resource('squads', App\Http\Controllers\TeacherSquadController::class);
        Route::get('squads-preview', [App\Http\Controllers\TeacherSquadController::class, 'preview'])->name('squads.preview');
    });
});
