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
        Schema::create('squads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->bigInteger('leader_nisn');
            $table->text('members_nisn');
            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->enum('status', ['on-progress', 'diterima', 'pengajuan', 'unknown'])->default('pengajuan');
            $table->timestamps();

            // Add indexes
            $table->index('leader_nisn');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squads');
    }
};
