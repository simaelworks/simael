<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteSquad extends Model
{
    //
    protected $fillable = [
        'squad_id',
        'student_id'
    ];
    
    public function squad() {
        return $this->belongsTo(Squad::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
