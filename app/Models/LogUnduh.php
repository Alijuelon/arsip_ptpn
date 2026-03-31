<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogUnduh extends Model
{
    protected $fillable = ['user_id', 'dokumen_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function dokumen() {
        return $this->belongsTo(Dokumen::class);
    }
}