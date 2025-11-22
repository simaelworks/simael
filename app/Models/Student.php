<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $fillable = [
        'name',
        'nisn',
        'major',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
