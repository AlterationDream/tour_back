<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',
        'name',
        'parent_id',
        'order',
        'shape',
        'image',
    ];
}
