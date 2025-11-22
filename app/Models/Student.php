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

    // ============ ELOQUENT EVENTS ============

    /**
     * The "updated" event that is fired after a model is updated.
     * Saat NISN berubah, otomatis update squad data yang berelasi.
     */
    protected static function booted()
    {
        static::updated(function (Student $student) {
            // Check if NISN changed
            if ($student->isDirty('nisn')) {
                $oldNisn = $student->getOriginal('nisn');
                $newNisn = $student->nisn;

                // Update squad dimana student adalah leader
                $leaderSquads = Squad::where('leader_nisn', $oldNisn)->get();
                foreach ($leaderSquads as $squad) {
                    $squad->update(['leader_nisn' => $newNisn]);
                }

                // Update squad where student are member
                $memberSquads = Squad::where('members_nisn', 'LIKE', "%$oldNisn%")
                    ->get();
                foreach ($memberSquads as $squad) {
                    // Replace old NISN with new NISN in members_nisn string
                    $memberNisns = array_map('trim', explode(',', $squad->members_nisn ?? ''));
                    $memberNisns = array_map(function($nisn) use ($oldNisn, $newNisn) {
                        return $nisn === $oldNisn ? $newNisn : $nisn;
                    }, $memberNisns);
                    $squad->update(['members_nisn' => implode(', ', $memberNisns)]);
                }

                // --- NEW: Update student's squad_id if their new NISN is in any squad's members_nisn ---
                $squadWithNewNisn = Squad::whereRaw('FIND_IN_SET(?, members_nisn)', [$newNisn])->first();
                if ($squadWithNewNisn) {
                    $student->squad_id = $squadWithNewNisn->id;
                    $student->saveQuietly(); // avoid recursion
                } else {
                    // If not found in any squad, clear squad_id
                    $student->squad_id = null;
                    $student->saveQuietly();
                }
            }
        });
    }

    // ============ NEW ELOQUENT RELATIONSHIPS ============

    /**
     * Get the squad this student is assigned to (via squad_id)
     */
    public function squad()
    {
        return $this->belongsTo(Squad::class, 'squad_id');
    }

    /**
     * Get squads where this student is the leader
     */
    public function leaderOfSquads()
    {
        return $this->hasMany(Squad::class, 'leader_id');
    }

    /**
     * Get squads where this student is a member
     */
    public function memberOfSquads()
    {
        return $this->belongsToMany(Squad::class, 'squad_members', 'student_id', 'squad_id');
    }

    // ============ LEGACY METHODS (for backward compatibility) ============

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

