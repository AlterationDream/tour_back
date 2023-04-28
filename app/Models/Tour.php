<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',
        'name',
        'categories',
        'duration',
        'starting',
        'schedule',
        'pricing',
        'length',
        'video',
        'short_description',
        'program',
        'additional',
        'booking',
        'image'
    ];
}
