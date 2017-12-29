<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return 'mobile';
    }

    public function showLogin(){
        return view('admin.login');
    }

    public function login(Request $request){
        try {
            if ($this->guard()->attempt($this->credentials($request))) {
                return $this->success([
                    'user'     => $this->guard()->user()
                ]);
            }else{
                return $this->error('1', '认证失败');
            }
            
        } catch (\Exception $e) {
            return $this->error('2', '位置错误，请联系技术人员');
        }

    }

    public function credentials(Request $request)
    {
        return [
            $this->username() => $request->input('mobile'),
            'password'        => $request->input('password'),
            'is_admin'        => 1,
        ];
    }
}
