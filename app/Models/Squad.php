<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Squad Model
 * 
 * Represents a squad/group with a leader and members.
 * 
 * @property int $id
 * @property string $name
 * @property int $leader_id Foreign key to students.id (the squad leader)
 * @property string $nama_perusahaan
 * @property string $alamat_perusahaan
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
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

    // ============ ELOQUENT RELATIONSHIPS ============

    /**
     * Get the student who leads this squad
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leaderStudent()
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    /**
     * Get all members of this squad (excluding leader)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Student::class, 'squad_id');
    }

    /**
     * Get all members including the leader
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allMembers()
    {
        $leader = $this->leaderStudent;
        $members = $this->members()->get();

        if (!$leader) {
            return $members;
        }

        return collect([$leader])->merge($members)->unique('id');
    }

    /**
     * Get count of squad members (excluding leader)
     * 
     * @return int
     */
    public function memberCount()
    {
        return $this->members()->count();
    }

    /**
     * Get total count including leader
     * 
     * @return int
     */
    public function totalMemberCount()
    {
        return $this->memberCount() + ($this->leaderStudent ? 1 : 0);
    }
}

