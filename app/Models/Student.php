<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'name',
        'nisn',
        'major',
        'password',
        'status',
        'squad_id',
    ];

    public function squad()
    {
        return $this->belongsTo(Squad::class);
    }

    public function leadingSquads()
    {
        return $this->hasMany(Squad::class);
    }
}
