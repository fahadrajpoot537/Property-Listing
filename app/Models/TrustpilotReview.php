<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustpilotReview extends Model
{
    protected $fillable = [
        'rating', // e.g., "4.9"
        'review_count', // e.g., "1234"
        'is_active',
    ];
}
