<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Controllers\Api\ApiController;

class UserController extends ApiController
{
    protected $apiProvider = 'users';

    public function  __construct()
    {
        parent::__construct();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $this->getUserFromAccessToken();

        if (\Hash::check($request->old_password, $user->password)) {
            $user->password = $request->new_password;
            $user->save();

            return $this->response(['message' => trans('auth.change_pass_sucess')]);
        } 

        return $this->response(['error' => trans('auth.old_pass_incorrect')], 401);
    }
}
