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
        Schema::create('laporan_arsips', function (Blueprint $table) {
            $table->id();
            $table->string('periode', 50); 
            $table->integer('total_dokumen')->default(0); 
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete(); 
            $table->timestamps(); // created_at berfungsi sebagai tanggal_laporan 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_arsips');
    }
};
