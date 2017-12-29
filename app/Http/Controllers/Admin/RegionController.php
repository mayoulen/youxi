<?php

namespace App\Http\Controllers\Admin;

use Cache;
use App\Region;
use Illuminate\Http\Request;

class RegionController extends BaseController
{
    public function index(Request $request){
        try {
	        $lists = Cache::rememberForever('users', function () {
	        	$region = new Region;
	            $list = $region->select(
	            	'id','parent_id','name as value', 'name as label'
	            )->get()->toArray();

	            return $region->listToree($list, 'id', 'parent_id', 'children', 1);
	        });

        	return $this->success($lists);

        } catch (\Exception $e) {
        	$this->error(100, $e->getMessage());
        }
    }
}
