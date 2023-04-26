<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoorDesa extends Model
{
    use HasFactory;
    protected $table = 'koor_desa';

    protected $fillable = [
        'user_id',
        'koor_kecamatan_id',
        'name',
        'slug',
        'total_dpt',
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

    public function kecamatan()
    {
        return $this->belongsTo(KoorKecamatan::class, 'koor_kecamatan_id');
    }

    public function dpt()
    {
        return $this->hasMany(Dpt::class, 'desa_id');
    }

    public function getDptCountIsVotersAttribute()
    {
        return $this->dpt()->where('is_voters', true)->count();
    }

    public function tps()
    {
        return $this->hasMany(KoorTps::class);
    }
}
