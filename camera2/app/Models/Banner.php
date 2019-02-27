<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const POSITION_SLIDER = 'banner';
    const POSITION_AD = 'ad';
    const POSITION_PARTNER = 'partner';

    const STATUS_SHOW = true;
    const STATUS_HIDDEN = false;

    protected $fillable = [
        'link',
        'image',
        'name',
        'position',
        'status',
        'seo_keyword',
        'seo_description',
    ];

    public function getStatusAttribute($value)
    {
        return $value ? true : false;
    }
}
