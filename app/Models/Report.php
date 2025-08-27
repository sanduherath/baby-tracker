<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'file_path',
        'start_date',
        'end_date',
        'generated_at',
    ];

    protected $casts = [
        'file_path' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'generated_at' => 'datetime',
    ];
}
