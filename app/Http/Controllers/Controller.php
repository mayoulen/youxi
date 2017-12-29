<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = [], $message = '请求成功'){
    	return json_encode([
    		'code'    => '200',
    		'message' => $message,
    		'data'    => $data

    	], JSON_UNESCAPED_UNICODE);
    }

    public function error($code = '100', $message = '请求成功', $data = []){
    	return json_encode([
    		'code'    => $code,
    		'message' => $message,
    		'data'    => $data

    	], JSON_UNESCAPED_UNICODE);
    }

}
