<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\ApiController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::middleware('guest:teacher')->group(function () {
        Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherAuthController::class, 'login']);
    });
    Route::middleware('teacher.auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('teacher.dashboard');
        })->name('dashboard');
        Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');

        // Teacher students and squads resource routes
        Route::resource('students', App\Http\Controllers\TeacherStudentController::class);
        Route::resource('squads', App\Http\Controllers\TeacherSquadController::class);
        Route::match(['get', 'post'], 'squads-preview', [App\Http\Controllers\TeacherSquadController::class, 'preview'])->name('squads.preview');

        // Teacher API endpoints for search
        Route::get('/api/search-students', [ApiController::class, 'teacherSearchStudents'])->name('api.search-students');
        Route::get('/api/search-squads', [ApiController::class, 'teacherSearchSquads'])->name('api.search-squads');
    });
});
