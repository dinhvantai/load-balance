<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $guard = 'api';

    public function __construct()
    {
        $apiProvider = property_exists($this, 'apiProvider') ? $this->apiProvider : config('auth.defaults.apiProvider');

        //Change api provider
        return config(['auth.guards.api.provider' => $apiProvider]);
    }

    public function getUserFromAccessToken()
    {
        return \Auth::guard($this->guard)->user();
    }
}
