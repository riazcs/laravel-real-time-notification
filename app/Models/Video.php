<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $fillable = [
        'original_name', 'path'
    ];
    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
        'converted_for_streaming_at',
    ];

    protected $guarded = [];
}
