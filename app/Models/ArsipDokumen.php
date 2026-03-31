<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipDokumen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dokumen_id',
        'lokasi_arsip',
        'staff_id'
    ];

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }

    // Staff yang memasukkan ke arsip fisik
    public function staffPengarsip(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}