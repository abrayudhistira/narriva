<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'profile_picture',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mutator untuk mengenkripsi password.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Accessor untuk profile_picture sebagai base64.
     */
    public function getProfilePictureAttribute($value)
    {
        if ($value) {
            $mimeType = 'image/png'; // Default MIME type
            // Deteksi format gambar jika diperlukan
            if (substr($value, 0, 2) === "\xFF\xD8") {
                $mimeType = 'image/jpeg';
            }
            return "data:$mimeType;base64," . base64_encode($value);
        }
        return null;
    }
    /**
     * Mutator untuk menyimpan profile_picture sebagai blob.
     */
    public function setProfilePictureAttribute($value)
    {
        \Log::info('Profile Picture Data: ', ['value_type' => gettype($value)]);
    
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            \Log::info('Profile Picture is an UploadedFile');
            $this->attributes['profile_picture'] = file_get_contents($value->getRealPath());
        } elseif (is_string($value) && base64_decode($value, true)) {
            \Log::info('Profile Picture is Base64 encoded');
            $this->attributes['profile_picture'] = base64_decode($value);
        } elseif ($value === null) {
            \Log::info('Profile Picture is Null');
            $this->attributes['profile_picture'] = null;
        } else {
            \Log::error('Invalid Profile Picture format.', ['value' => $value]);
            throw new \InvalidArgumentException('Invalid profile picture format.');
        }
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');
    }
}