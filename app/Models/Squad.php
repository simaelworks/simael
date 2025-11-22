<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Squad Model
 * 
 * Represents a squad/group with NISN-based member management.
 * 
 * @property int $id
 * @property string $name
 * @property bigInteger $leader_nisn
 * @property text $members_nisn
 * @property string $nama_perusahaan
 * @property string $alamat_perusahaan
 * @property string $status
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

    public function leader()
    {
        return Student::where('nisn', $this->leader_nisn)->first();
    }

    public function members()
    {
        if (empty($this->members_nisn)) {
            return collect();
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return Student::whereIn('nisn', $nisns)->get();
    }

    public function memberCount()
    {
        if (empty($this->members_nisn)) {
            return 0;
        }

        $nisns = array_map('trim', explode(',', $this->members_nisn));
        return count(array_filter($nisns));
    }

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

