<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Squad Model
 * 
 * Represents a squad/group in the system.
 * Uses denormalized NISN-based relationship design instead of traditional foreign keys.
 * 
 * Squad Composition:
 * - leader_nisn: NISN of the leader (single student)
 * - members_nisn: Comma-separated NISNs of squad members
 * 
 * Design Notes:
 * - No foreign key constraint on Student table for flexibility
 * - Uses NISN instead of ID for easier student identification
 * - Members stored as CSV string to allow flexible membership
 * 
 * @property int $id
 * @property string $name Squad name (max 20 characters)
 * @property bigInteger $leader_nisn NISN of squad leader
 * @property text $members_nisn Comma-separated NISNs of squad members
 * @property string $nama_perusahaan Company name (nullable)
 * @property string $alamat_perusahaan Company address (nullable)
 * @property string $status Squad status (on-progress, diterima, pengajuan, unknown)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Squad extends Model
{
    protected $fillable = [
        'name',
        'leader_nisn',
        'members_nisn',
        'nama_perusahaan',
        'alamat_perusahaan',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the leader student by NISN
     * 
     * @return Student|null
     */
    public function leader()
    {
        return Student::where('nisn', $this->leader_nisn)->first();
    }

    /**
     * Get all member students by parsing members_nisn
     * Members NISN are stored as comma-separated values
     * 
     * @return \Illuminate\Support\Collection
     */
    public function members()
    {
        if (empty($this->members_nisn)) {
            return collect();
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return Student::whereIn('nisn', $nisns)->get();
    }

    /**
     * Get count of squad members
     * 
     * @return int
     */
    public function memberCount()
    {
        if (empty($this->members_nisn)) {
            return 0;
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return count(array_filter($nisns));
    }

    /**
     * Get leader and members combined as a single collection
     * 
     * @return \Illuminate\Support\Collection
     */
    public function allMembers()
    {
        $leader = $this->leader();
        if (!$leader) {
            return collect();
        }

        $members = $this->members();
        return collect([$leader])->merge($members);
    }
}

