<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // const POSITION_MAIN = 'main';
    const POSITION_ON_TOP_LEFT = 'top_left';
    const POSITION_ON_TOP_RIGHT = 'top_right';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'prioty',
        'path',
    ];
}
