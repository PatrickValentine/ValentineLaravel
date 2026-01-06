<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBoxSizeMatrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'greater_than',
        'qty_of_env',
        'box_style',
        'length',
        'width',
        'height',
        'empty_weight',
        'full_weight',
    ];

    protected $casts = [
        'greater_than' => 'integer',
        'qty_of_env' => 'integer',
        'length' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'empty_weight' => 'integer',
        'full_weight' => 'integer',
    ];
} 