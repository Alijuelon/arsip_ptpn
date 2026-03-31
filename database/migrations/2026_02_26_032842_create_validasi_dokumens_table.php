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
        Schema::create('validasi_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_id')->constrained('dokumens')->cascadeOnDelete(); 
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); 
            $table->enum('status_validasi', ['Disetujui', 'Ditolak']); 
            $table->text('catatan_validasi')->nullable(); 
            $table->timestamps(); // created_at berfungsi sebagai tanggal_validasi 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi_dokumens');
    }
};
