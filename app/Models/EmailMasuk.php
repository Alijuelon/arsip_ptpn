<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailMasuk extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'email_masuks';

    // Mengizinkan mass-assignment untuk semua kolom kecuali ID
    protected $guarded = ['id'];

    /**
     * Casting tipe data agar Laravel otomatis mengonversinya
     * saat data ditarik dari database.
     */
    protected $casts = [
        'is_read' => 'boolean',        // Mengubah 0/1 menjadi true/false
        'is_archived' => 'boolean',    // Mengubah 0/1 menjadi true/false
        'tanggal_terima' => 'datetime' // Mengubah format string tanggal menjadi objek Carbon (mudah diformat)
    ];
}