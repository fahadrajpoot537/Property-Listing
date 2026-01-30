<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MortgageSetting extends Model
{
    protected $fillable = [
        'down_payment_percentage',
        'interest_rate',
        'loan_term_years',
    ];
}
