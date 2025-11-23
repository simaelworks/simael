<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add squad_id column to students table to establish 1:Many relationship
     * where one squad can have many members, but each student belongs to only one squad.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('squad_id')->nullable()->after('status');
            $table->foreign('squad_id')->references('id')->on('squads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['squad_id']);
            $table->dropColumn('squad_id');
        });
    }
};
