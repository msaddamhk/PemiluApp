<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpt extends Model
{
    use HasFactory;

    protected $fillable = [
        "desa_id",
        "tps_id",
        "name",
        "identity number",
        "phone_number",
        "is_voters",
        "created_by",
        "updated_by",
    ];
}