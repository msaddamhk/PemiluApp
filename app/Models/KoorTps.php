<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorTps extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "koor_desa_id",
        'slug',
        "total_dpt_by_tps",
        "name",
        "created_by",
        "updated_by",
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

    public function koorDesas()
    {
        return $this->belongsTo(KoorDesa::class);
    }

    public function dpt()
    {
        return $this->hasMany(Dpt::class, 'tps_id');
    }

    public function dptIsVoters()
    {
        return $this->dpt()->where('is_voters', true);
    }

    public function getDptCountAttribute()
    {
        return $this->dpt()->count();
    }

    public function getDptIsVotersCountAttribute()
    {
        return $this->dptIsVoters()->count();
    }

    public function quickCount()
    {
        return $this->hasMany(QuickCount::class);
    }
}
