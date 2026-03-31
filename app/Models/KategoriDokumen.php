<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriDokumen extends Model
{
    use HasFactory;

    protected $table = 'kategori_dokumens';

    protected $fillable = [
        'nama_kategori',
        'kode_kategori'
    ];

    // Relasi: Satu kategori bisa dimiliki banyak dokumen
    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'kategori_id');
    }
}