<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Extra;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class ExtraController extends ApiController
{
    protected $apiProvider = 'users';

    public function  __construct()
    {
        parent::__construct();
    }

    public function getSetup()
    {
        $setups = Extra::select(['id', 'option', 'seo_keyword', 'seo_description', 'position'])
            ->where('position', Extra::POSITION_MAIN)->first();

        return $this->response($setups);
    }

    public function putSetup(Request $request)
    {
        $setups = Extra::where('position', Extra::POSITION_MAIN)->first();
        $setups->fill($request->all());
        $setups->option = json_encode($request->option);

        if ($setups->save()) {
            return $this->response(['message' => trans('message.edit_success')]);
        }

        return $this->response(['message' => trans('message.edit_failed')], 401);
    }
}
