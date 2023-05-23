<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function success($data, $message = '')
    {
        return $this->response('',$data->additional(['condition'=> true, 'message' => $message]));
    }
    public function fail($errors = [], $code = 422, $message = '')
    {
        return $this->response($message,[], $errors, $code, false);
    }
    public function response($message = '', $data,$errors = null, $code=200,$condition=true)
    {
        return response()->json([
            'data'=>$data,
            'message'=>$message,
            'errors' => $errors,
            'code' => $code,
            'condition' => $condition,
        ],$code);
    }
}
