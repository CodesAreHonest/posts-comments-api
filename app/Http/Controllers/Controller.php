<?php

namespace App\Http\Controllers;

use App\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function validator ($request, $rules) {

        $validator = Validator::make($request, $rules, config('validation'));

        if ($validator->fails()) {

            $errorMsg = [];

            foreach ($validator->errors()->all() as $value) {
                array_push($errorMsg, $value);
            }

            throw new UnprocessableEntityException($errorMsg);
        }
    }
}
