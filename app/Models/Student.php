<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Student Model
 * 
 * Represents a student in the system with NISN-based squad relationships.
 * 
 * @property int $id
 * @property string $name
 * @property string $nisn
 * @property string $major
 * @property string $password
 * @property string $status
 */
class Student extends Authenticatable
{
    protected $fillable = [
        'name',
        'nisn',
        'major',
        'password',
        'status',
    ];

    public function leadingSquads()
    {
        return Squad::where('leader_nisn', $this->nisn)->get();
    }

    public function memberSquads()
    {
        $squads = Squad::all();
        return $squads->filter(function ($squad) {
            $memberNisns = array_map('trim', explode(',', $squad->members_nisn ?? ''));
            return in_array($this->nisn, $memberNisns);
        });
    }

    public function allSquads()
    {
        $leadingSquads = $this->leadingSquads();
        $memberSquads = $this->memberSquads();
        return $leadingSquads->merge($memberSquads);
    }

    /**
     * Get squads where this student is a leader or member (for use in views)
     * Queries both leader_nisn and members_nisn fields
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAssociatedSquads()
    {
        return Squad::where(function($query) {
            $query->where('leader_nisn', $this->nisn)
                  ->orWhereRaw("FIND_IN_SET(?, members_nisn)", [$this->nisn]);
        })->get();
    }
}

