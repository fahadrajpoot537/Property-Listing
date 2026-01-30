<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
    protected $fillable = [
        'name',
        'image',
        'address',
        'latitude',
        'longitude',
    ];
}
