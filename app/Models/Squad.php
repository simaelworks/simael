<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'company_name',
        'company_address',
        'status',
        'leader_id',
    ];

    public function leader()
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    public function users()
    {
        return $this->hasMany(Student::class);
    }
}
