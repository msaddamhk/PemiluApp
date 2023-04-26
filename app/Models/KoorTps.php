<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoorTps extends Model
{
    use HasFactory;

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

    public function koorDesa()
    {
        return $this->belongsTo(KoorDesa::class);
    }
}
