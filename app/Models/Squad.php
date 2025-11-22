<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     */
    public function leader()
    {
        return Student::where('nisn', $this->leader_nisn)->first();
    }

    /**
     * Get all member students by parsing members_nisn
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
     * Get member count
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
     * Get leader and members combined
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
