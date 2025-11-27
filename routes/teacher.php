<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherAuthController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::middleware('guest:teacher')->group(function () {
        Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherAuthController::class, 'login']);
    });
    Route::middleware('teacher.auth')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('teacher.students.index');
        })->name('dashboard');
        Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');

        // Teacher students and squads resource routes
        Route::resource('students', App\Http\Controllers\TeacherStudentController::class);
        Route::resource('squads', App\Http\Controllers\TeacherSquadController::class);
        Route::get('squads-preview', [App\Http\Controllers\TeacherSquadController::class, 'preview'])->name('squads.preview');
    });
});
