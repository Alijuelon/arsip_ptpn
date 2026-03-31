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
        Schema::create('arsip_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_id')->constrained('dokumens')->cascadeOnDelete(); 
            $table->string('lokasi_arsip', 100)->nullable(); // Misal: Lemari A1 
            $table->foreignId('staff_id')->constrained('users')->cascadeOnDelete(); 
            $table->timestamps(); // created_at berfungsi sebagai tanggal_arsip 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_dokumens');
    }
};
