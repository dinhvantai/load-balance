<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function getSlider()
    {
        $sliders = Banner::where('status', Banner::STATUS_SHOW)
            ->where('position', Banner::POSITION_SLIDER)
            ->orderBy('id', 'desc')->get();

        return $this->response($sliders);
    }
}
