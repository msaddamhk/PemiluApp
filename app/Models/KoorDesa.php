<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function dpts()
    {
        return $this->hasMany(Dpt::class, 'desa_id');
    }

    public function getDptCountAttribute()
    {
        return $this->dpts()->count();
    }

    public function getDptIsVotersCountAttribute()
    {
        return $this->dpts()->where('is_voters', true)->count();
    }

    public function koortps()
    {
        return $this->hasMany(KoorTps::class, 'koor_desa_id');
    }

    public function quickCount()
    {
        return $this->hasMany(QuickCount::class);
    }

    public function getCountForGeneral()
    {
        return $this->count();
    }
}
