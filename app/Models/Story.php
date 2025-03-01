<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'story';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['user_id', 'image'];

    /**
     * Scope untuk mendapatkan story yang belum expired.
     */
    public function scopeActive($query)
    {
        return $query->where('created_at', '>=', now()->subHours(24));
    }

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}