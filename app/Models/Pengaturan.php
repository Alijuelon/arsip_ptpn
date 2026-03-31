<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (opsional tapi disarankan)
    protected $table = 'pengaturans';

    // Mengizinkan mass-assignment untuk semua kolom kecuali ID
    protected $guarded = ['id'];
    
    // Atau jika Anda lebih suka menggunakan fillable:
    // protected $fillable = ['kunci', 'nilai'];
}