<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Squad;
use App\Models\Student;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Ensure all squad leaders have the correct squad_id assigned
     */
    public function up(): void
    {
        // Update all squad leaders with their correct squad_id
        DB::statement('
            UPDATE students s
            INNER JOIN squads sq ON s.nisn = sq.leader_nisn
            SET s.squad_id = sq.id
            WHERE s.squad_id IS NULL OR s.squad_id != sq.id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only adds missing squad_id values, no need to reverse
        // as it's a data correction, not a schema change
    }
};
