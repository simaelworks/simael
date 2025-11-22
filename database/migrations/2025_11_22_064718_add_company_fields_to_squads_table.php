<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('squads', function (Blueprint $table) {
            $table->string('nama_perusahaan')->nullable()->after('members_nisn');
            $table->text('alamat_perusahaan')->nullable()->after('nama_perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('squads', function (Blueprint $table) {
            $table->dropColumn(['nama_perusahaan', 'alamat_perusahaan']);
        });
    }
};
