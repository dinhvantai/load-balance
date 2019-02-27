<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    const POSITION_MAIN = 'main';

    protected $fillable = [
        'position',
        'seo_keyword',
        'seo_description',
    ];
}
