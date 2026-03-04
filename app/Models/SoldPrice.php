<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'postcode',
        'price',
        'sold_at',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'sold_at' => 'date',
    ];
}
