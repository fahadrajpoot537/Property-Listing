<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_id',
        'url',
        'method',
        'user_agent',
        'country',
        'city',
        'device',
        'platform',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
