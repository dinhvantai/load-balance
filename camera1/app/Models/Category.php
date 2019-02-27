<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TYPE_PRODUCT = 'product';
    const TYPE_POST = 'post';

    const STATUS_SHOW = true;
    const STATUS_HIDDEN = false;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'type',
        'prioty',
        'status',
        'parent_id',
        'seo_keyword',
        'seo_description',
    ];

    public function getStatusAttribute($value)
    {
        return $value ? true : false;
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
