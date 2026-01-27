<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = ['title', 'meta_title', 'meta_keywords', 'meta_description', 'description'];
}
