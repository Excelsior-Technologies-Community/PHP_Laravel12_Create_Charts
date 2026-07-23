<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $fillable = ['title', 'type', 'labels', 'values', 'options', 'theme'];

    protected $casts = [
        'labels' => 'array',
        'values' => 'array',
        'options' => 'array',
    ];
}
