<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Student Model
 * 
 * Represents a student in the system.
 * Students can be leaders of squads or members of squads.
 * The squad relationships are managed through NISN (Nomor Induk Siswa Nasional)
 * stored in the Squad model's leader_nisn and members_nisn fields.
 * 
 * @property int $id
 * @property string $name Student's full name
 * @property string $nisn Student ID number (Nomor Induk Siswa Nasional)
 * @property string $major Student's major (PPLG, TJKT, BCF, DKV)
 * @property string $password Hashed password for authentication
 * @property string $status Account status (verified, pending)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
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

    /**
     * Get squads where this student is a leader
     * Uses NISN-based relationship: Squad.leader_nisn = Student.nisn
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function leadingSquads()
    {
        return Squad::where('leader_nisn', $this->nisn)->get();
    }

    /**
     * Get squads where this student is a member
     * Uses NISN-based relationship: Squad.members_nisn contains Student.nisn
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function memberSquads()
    {
        $squads = Squad::all();
        return $squads->filter(function ($squad) {
            $memberNisns = array_map('trim', explode(',', $squad->members_nisn ?? ''));
            return in_array($this->nisn, $memberNisns);
        });
    }

    /**
     * Get all squads this student is associated with (as leader or member)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allSquads()
    {
        $leadingSquads = $this->leadingSquads();
        $memberSquads = $this->memberSquads();
        return $leadingSquads->merge($memberSquads);
    }
}

