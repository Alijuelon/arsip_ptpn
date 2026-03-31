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
    Schema::create('pengaturans', function (Blueprint $table) {
        $table->id();
        $table->string('kunci')->unique(); // cth: 'email_pusat'
        $table->string('nilai')->nullable(); // cth: 'pusat@ptpn4.co.id'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
