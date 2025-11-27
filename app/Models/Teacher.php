<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nik',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
