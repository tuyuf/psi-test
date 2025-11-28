<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'alternate_email',
        'username',
        'jenis_kelamin',
        'usia',
        'masa_kerja',
        'unit_kerja',
        'alamat',
        'telepon',
        'health_history',
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }

    public function latestHasil() {
        return $this->hasOne(Hasil::class)->latestOfMany();
    }

    public function hasUnfinishedHasil() {
        if ($this->latestHasil) {
            return $this->latestHasil->status_pengerjaan === 'belum selesai';
        }
        return false;
    }
}
