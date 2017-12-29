<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        try {
        	$sortProp  = $request->input('sort_prop', 'created_at');
        	$sortOrder = $request->input('sort_order', 'DESC');
        	$is_admin  = $request->input('is_admin', NULL);
        	$is_agent  = $request->input('is_agent', NULL);
        	$wd     = $request->input('wd', NULL);
        	$user = (new User)
                ->when(NULL != $is_admin, function ($query) use ($is_admin) {
                    return $query->where('is_admin', $is_admin);
                })
                ->when(NULL != $is_agent, function ($query) use ($is_agent) {
                    return $query->where('is_agent', $is_agent);
                })
                ->when(!empty($wd), function ($query) use ($wd) {
                    return $query->where('name', 'like', trim($wd)."%")
                    			->orWhere('mobile', 'like', trim($wd)."%");
                })
                ->orderBy($sortProp, $sortOrder)
                ->paginate();

        	return $this->success($user);
        	
        } catch (\Exception $e) {
        	return $this->error(100, $e->getMessage());
        }
    }

    public function create(Request $request)
    {
	    // try {
	    	$input = $request->only([
	    		'mobile', 'password' ,'name', 'sex', 'is_admin',
	    		'is_agent', 'headimgurl', 'province',
	    		'city', 'country', 'unionid'
	    	]);

	        $validator = Validator::make($input, [
	            'name' => 'required',
	            'mobile' => 'required|unique:users,mobile|regex:/^1[34578]{1}\d{9}$/',
	            'password' =>'required'
	        ]);
	        if ($validator->fails()) {
	            return $this->error(102, $validator->messages()->first());
	        }

	        $input['password'] = bcrypt($input['password']);

	        if( $user = (new User)->create($input) ){
	        	return $this->success($user);
	        }

	        return $this->error(100, "用户保存失败");
    	// } catch (\Exception $e) {
    	// 	return $this->error(107, $e->getMessage());		
    	// }
    }

    public function edit(Request $request)
    {
	    try {
	    	$user = (new User)->findOrFail($request->input('id'));

	    	$input = $request->only([
	    		'mobile', 'password' ,'name', 'sex', 'is_admin',
	    		'is_agent', 'headimgurl', 'province',
	    		'city', 'country', 'unionid'
	    	]);

	        $validator = Validator::make($input, [
	            'name'   => 'required',
                'mobile' => [
                    'required',
                	'regex:/^1[34578]{1}\d{9}$/',
                    Rule::unique('users')->ignore($user->id),
                ]
	        ]);
	        if ($validator->fails()) {
	            return $this->error(102, $validator->messages()->first());
	        }
	        if(!empty($input['password'])){
	        	$input['password'] = bcrypt($input['password']);
	        }

	        if( $user->fill($input)->save() ){
	        	return $this->success($user);
	        }

	        return $this->error(100, "用户保存失败");
    	} catch (\Exception $e) {
    		return $this->error(107, $e->getMessage().$e->getFile().$e->getLine());		
    	}
    }

    public function info(Request $request){
        try {

            return $this->success(
                (new User)->findOrFail($request->input('id'))
            );

        } catch (\Exception $e) {

            return $this->error(100, $e->getMessage());
        }
    }

    public function destory(Request $request){
        try{
            if(empty($request->input('id'))){
                return $this->error(101, '缺少参数');
            }

            $deleteRow = (new User)->destroy($request->input('id'));

            return $this->success(['affectRow'=>$deleteRow], '删除成功');

        }catch(\Exception $e){

            return $this->error(100, $e->getMessage());
        }
    }


}
