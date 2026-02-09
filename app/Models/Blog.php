<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'author',
        'published_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}