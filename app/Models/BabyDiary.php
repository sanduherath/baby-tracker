<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyDiary extends Model
{
    use HasFactory;

    protected $table = 'baby_diaries';

    protected $fillable = [
        'baby_id',
        'entry_date',
        'entry_time',
        'title',
        'description',
        'mood',
        'photo_path',
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
