<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    protected $fillable = [
        'name',
        'nik',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
