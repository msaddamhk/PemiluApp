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
        "total_dpt_by_tps",
        "name",
        "created_by",
        "updated_by",
    ];

}