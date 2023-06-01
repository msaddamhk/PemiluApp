<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dpt extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dpt';
    protected $fillable = [
        "desa_id",
        "tps_id",
        "name",
        "indentity_number",
        "phone_number",
        "is_voters",
        "date_of_birth",
        "gender",
        "created_by",
        "updated_by",
    ];

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

    public function koorTps()
    {
        return $this->belongsTo(KoorTps::class, 'tps_id');
    }
}
