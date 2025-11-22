<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Squad Model
 * 
 * Represents a squad/group with member management.
 * 
 * @property int $id
 * @property string $name
 * @property bigInteger $leader_id
 * @property bigInteger $leader_nisn (legacy)
 * @property text $members_nisn (legacy)
 * @property string $nama_perusahaan
 * @property string $alamat_perusahaan
 * @property string $status
 */
class Squad extends Model
{
    protected $fillable = [
        'name',
        'leader_id',
        'leader_nisn',
        'members_nisn',
        'nama_perusahaan',
        'alamat_perusahaan',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // ============ NEW ELOQUENT RELATIONSHIPS ============

    /**
     * Get the student who leads this squad
     */
    public function leaderStudent()
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    /**
     * Get all members of this squad
     */
    public function members()
    {
        return $this->belongsToMany(Student::class, 'squad_members', 'squad_id', 'student_id');
    }

    /**
     * Get all members including the leader
     */
    public function allMembers()
    {
        $leader = $this->leaderStudent;
        if (!$leader) {
            return $this->members()->get();
        }
        
        return collect([$leader])->merge($this->members()->get())->unique('id');
    }

    /**
     * Get count of squad members (excluding leader)
     */
    public function memberCount()
    {
        return $this->members()->count();
    }

    // ============ LEGACY METHODS (for backward compatibility) ============

    public function leader()
    {
        return Student::where('nisn', $this->leader_nisn)->first();
    }

    public function membersLegacy()
    {
        if (empty($this->members_nisn)) {
            return collect();
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return Student::whereIn('nisn', $nisns)->get();
    }

    public function memberCountLegacy()
    {
        if (empty($this->members_nisn)) {
            return 0;
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return count(array_filter($nisns));
    }

    public function allMembersLegacy()
    {
        $leader = $this->leader();
        if (!$leader) {
            return collect();
        }

        $members = $this->membersLegacy();
        return collect([$leader])->merge($members);
    }
}

