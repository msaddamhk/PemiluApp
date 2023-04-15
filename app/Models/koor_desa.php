<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koor_desa extends Model
{
    use HasFactory;
    protected $table = 'koor_desas';

    protected $fillable = [
        'user_id',
        'koor_kecamatan_id',
        'name',
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

    public function Kecamatan()
    {
        return $this->belongsTo(koor_kecamatan::class, 'koor_kecamatan_id');
    }
}
