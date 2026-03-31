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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul_dokumen', 150); 
            $table->foreignId('kategori_id')->constrained('kategori_dokumens')->restrictOnDelete();
            $table->string('file_dokumen', 255); 
            $table->foreignId('pengirim_id')->constrained('users')->cascadeOnDelete(); 
            $table->enum('status_dokumen', ['Menunggu', 'Disetujui', 'Ditolak','Disposisi'])->default('Menunggu'); 
            $table->text('keterangan')->nullable(); 
            $table->timestamps(); // created_at berfungsi sebagai tanggal_upload [cite: 467]
            $table->softDeletes(); // Keamanan agar file tidak benar-benar hilang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
