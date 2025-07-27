<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['baby_id', 'description', 'details', 'activity_date'];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
