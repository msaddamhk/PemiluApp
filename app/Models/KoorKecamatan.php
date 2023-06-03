<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorKecamatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'koor_kecamatan';

    protected $fillable = [
        'user_id',
        'koor_kota_id',
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

    public function kota()
    {
        return $this->belongsTo(KoorKota::class, 'koor_kota_id');
    }

    public function koorDesas()
    {
        return $this->hasMany(KoorDesa::class);
    }

    public function jumlahDesa()
    {
        return $this->koorDesas()->count();
    }

    public function getCountKecamatanForGeneral()
    {
        return $this->count();
    }
}
