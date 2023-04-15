<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koor_kota extends Model
{
    use HasFactory;

    protected $table = 'koor_kotas';

    protected $fillable = [
        'user_id',
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

    public function kecamatan()
    {
        return $this->hasMany(koor_kecamatan::class);
    }
}
