<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_SHOW = true;
    const STATUS_HIDDEN = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'detail',
        'status',
        'image',
        'prioty',
        'category_id',
        'seo_keyword',
        'seo_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getStatusAttribute($value)
    {
        return $value ? true : false;
    }
}
