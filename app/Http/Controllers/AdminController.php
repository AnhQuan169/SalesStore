<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Thư viện cho phép kết nối với Database
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Yoeunes\Toastr;
Session_start();

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin_login');
    }

    public function show_dashboard(){
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        $admin_mail = $request->admin_mail;
        $admin_password = MD5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_mail',$admin_mail)->where('admin_password',$admin_password)->first();

        if($result){
            //Lấy name, id của người dùng từ biến $result khi đăng nhập thành công
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            // Trả về trang dashboard
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Tài khoản hoặc mật khẩu không chính xác');
            return Redirect::to('/admin')->with('error','Đăng nhập không thành công');
        }
    }

    public function logout(){
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
