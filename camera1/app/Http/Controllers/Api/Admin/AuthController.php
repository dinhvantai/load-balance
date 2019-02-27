<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController
{
    protected $apiProvider = 'users';

    public function  __construct()
    {
        parent::__construct();
    }

    public function login(Request $request)
    {
        if ($validator = $this->notValidateLogin($request)) {
            return $this->response($validator, 400);
        }
        if (!$this->attemptLogin($request)) {
            return $this->response(['errors' => ['message' => trans('auth.failed')]], 400);
        }

        return $this->response([
            'user' => \Auth::user(),
            'token' => $this->getToken($request)
        ]);
    }

    public function logout(Request $request)
    {
        if ($user = $this->getUserFromAccessToken()) {
            $user->token()->revoke();

            return $this->response(['message' => trans('auth.logout.success')], 200);
        }

        return $this->response(['errors' => ['message' => trans('auth.logout.warning')]], 400);
    }

    protected function attemptLogin(Request $request)
    {
        return \Auth::guard('web')
            ->attempt($request->only('email', 'password'), true);
    }

    protected function getToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => env('API_PASSWORD_CLIENT_ID'),
            'client_secret' => env('API_PASSWORD_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ]);
        $proxy = Request::create('oauth/token', 'POST');

        return json_decode(\Route::dispatch($proxy)->getContent());
    }

    protected function notValidateLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), $rule = [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$validator->fails()) {
            return false;
        }

        foreach ($rule as $key => $value) {
            if ($error = $validator->messages()->first($key)) {
                $response['errors'][$key] = $error;
            }
        }

        return $response;
    }
}
