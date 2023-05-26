<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'photo',
        'level',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function koorKota()
    {
        return $this->hasOne(KoorKota::class);
    }

    public function koorKecamatan()
    {
        return $this->hasOne(KoorKecamatan::class);
    }

    public function koorDesa()
    {
        return $this->hasOne(KoorDesa::class);
    }
    public function tps()
    {
        return $this->hasOne(KoorTps::class);
    }
}
