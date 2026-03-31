<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('email_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('gmail_id')->nullable()->unique();
            $table->string('pengirim');
            $table->string('subjek')->nullable();
            $table->text('isi_pesan')->nullable();
            $table->string('file_lampiran')->nullable(); // Path file PDF/Word
            $table->string('nama_file')->nullable();
            $table->boolean('is_read')->default(false); // Status dibaca
            $table->boolean('is_archived')->default(false); // Status sudah diarsipkan atau belum
            $table->timestamp('tanggal_terima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_masuks');
    }
};
