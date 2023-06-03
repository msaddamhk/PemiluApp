<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorKota extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'koor_kota';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
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

    public function koorKecamatans()
    {
        return $this->hasMany(KoorKecamatan::class);
    }

    public function jumlahKecamatan()
    {
        return $this->koorKecamatans()->count();
    }
}
