<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dokumen extends Model
{
    use HasFactory, SoftDeletes; // Pakai SoftDeletes agar arsip aman

    protected $fillable = [
        'judul_dokumen',
        'kategori_id',
        'file_dokumen',
        'pengirim_id',
        'status_dokumen',
        'keterangan'
    ];

    // Dokumen milik satu kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_id');
    }

    // Dokumen diupload oleh satu user (karyawan)
    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    // Dokumen bisa memiliki beberapa history validasi (Misal ditolak lalu dicek lagi)
    public function validasis(): HasMany
    {
        return $this->hasMany(ValidasiDokumen::class, 'dokumen_id');
    }

    // Jika valid, dokumen akan punya satu data di tabel arsip
    public function arsip(): HasOne
    {
        return $this->hasOne(ArsipDokumen::class, 'dokumen_id');
    }
}