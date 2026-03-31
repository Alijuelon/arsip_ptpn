<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_user',
        'nip',
        'email',
        'password',
        'role',
        'departemen_id',
        // TAMBAHKAN 3 BARIS INI:
        'google_access_token',
        'google_refresh_token',
        'google_email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi User ke Departemen
    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    // Relasi dokumen yang diupload oleh user ini
    public function dokumenUploads(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'pengirim_id');
    }

    // Relasi dokumen yang divalidasi (jika dia admin)
    public function validasiDokumens(): HasMany
    {
        return $this->hasMany(ValidasiDokumen::class, 'admin_id');
    }

    // Relasi arsip yang dibuat (jika dia admin/staff)
    public function arsipDokumens(): HasMany
    {
        return $this->hasMany(ArsipDokumen::class, 'staff_id');
    }

    // Kotak masuk disposisi (Penerima)
    public function disposisiMasuk(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'penerima_id');
    }
}