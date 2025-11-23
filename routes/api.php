<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


Route::controller(ApiController::class)->group(function() {
    Route::get('/api/students', 'getStudent')->name('getStudent');
    Route::post('/api/invite', 'inviteStudent')->name('inviteStudent');
})->middleware('student.auth');