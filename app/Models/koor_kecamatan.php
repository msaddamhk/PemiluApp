<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koor_kecamatan extends Model
{
    use HasFactory;
    protected $table = 'koor_kecamatans';

    protected $fillable = [
        'user_id',
        'koor_kota_id',
        'name',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function KabupatenKota()
    {
        return $this->belongsTo(koor_kota::class, 'koor_kota_id');
    }

    public function desa()
    {
        return $this->hasMany(koor_desa::class);
    }
}
