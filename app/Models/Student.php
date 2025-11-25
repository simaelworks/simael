<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
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
