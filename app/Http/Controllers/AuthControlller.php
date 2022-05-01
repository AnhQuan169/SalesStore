<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AuthControlller extends Controller
{
    //=== Đăng kí ===
    public function register_auth(){
        return view('admin.custom_auth.register');
    }

    // Đăng ký tài khoản Auth
    public function register(Request $request){
        $this->validation($request);
        $data = $request->all();

        $admin = new Admin();
        $admin->admin_mail = $data['admin_mail'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->save();
        return redirect('/register-auth')->with('message','Đăng ký thành công');
    }

    public function validation($request){
        return $this->validate($request,[
            'admin_mail' =>'required|email|max:255',
            'admin_password' =>'required|max:255',
            'admin_name' =>'required|max:255',
            'admin_phone' =>'required|max:10',
        ]);
    }

    // === Đăng nhập với Auth ===
    public function login_auth(){
        return view('admin.custom_auth.login_auth');
    }

    public function login(Request $request){
        $this->validate($request,[
            'admin_mail' =>'required|email|max:255',
            'admin_password' =>'required|max:255',
        ]);

        // $data = $request->all();
        if(Auth::attempt(['admin_mail'=> $request->admin_mail, 'admin_password' => $request->admin_password])){
            return redirect('/dashboard');
        }else{
            return redirect('/login-auth')->with('message','Đăng nhập không thành công');
        }
    }

    // Đăng xuất
    public function logout_auth(){
        Auth::logout();
        return redirect('/login-auth')->with('message','Đăng xuất thành công');
    }
}
