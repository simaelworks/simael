<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
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

    public function invites()
    {
        return $this->hasMany(InviteSquad::class);
    }

    public function leadingSquads()
    {
        return $this->hasMany(Squad::class);
    }
}
