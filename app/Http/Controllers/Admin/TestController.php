<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Region;

class TestController extends BaseController
{
    public function index(Request $request){
        $region = new Region;

        // $value = Cache::remember('users', $minutes, function () {
        //     return DB::table('users')->get();
        // });
            $list = $region->select('id','parent_id','name as value', 'name as label')->get()->toArray();

        return $region->listToree($list);
    }
}
