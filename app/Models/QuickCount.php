<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCount extends Model
{
    use HasFactory;

    protected $table = 'quick_count';

    protected $fillable = [
        'koor_tps_id',
        'number_of_votes',
        'total_votes',
        'result_photo',
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

    public function Tps()
    {
        return $this->belongsTo(KoorTps::class);
    }
}
