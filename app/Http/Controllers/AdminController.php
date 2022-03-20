<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Social;
use Illuminate\Http\Request;
// Thư viện cho phép kết nối với Database
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Rules\Captcha;
use Validator;
use Yoeunes\Toastr;
Session_start();

class AdminController extends Controller
{

    // Bảo mật Login
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    //
    public function index(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return view('admin_login');
        }    
    }

    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        // Cách 1: Dùng Db
        // $admin_mail = $request->admin_mail;
        // $admin_password = MD5($request->admin_password);

        // $result = DB::table('tbl_admin')->where('admin_mail',$admin_mail)->where('admin_password',$admin_password)->first();

        // if($result){
        //     //Lấy name, id của người dùng từ biến $result khi đăng nhập thành công
        //     Session::put('admin_name',$result->admin_name);
        //     Session::put('admin_id',$result->admin_id);
        //     // Trả về trang dashboard
        //     return Redirect::to('/dashboard');
        // }else{
        //     Session::put('message','Tài khoản hoặc mật khẩu không chính xác');
        //     return Redirect::to('/admin')->with('error','Đăng nhập không thành công');
        // }

        //Cách 2: Dùng Model
        // $data = $request->all();

        $data = $request->validate([
            // Validation laravel
            'admin_mail' => 'required',
            'admin_password' => 'required',
           'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

        $admin_mail = $data['admin_mail'];
        $admin_password = MD5($data['admin_password']);
        
        $login = Login::where('admin_mail',$admin_mail)->where('admin_password',$admin_password)->first();
        
        if($login){
            $login_count = $login->count();
            if($login_count){
                //Lấy name, id của người dùng từ biến $result khi đăng nhập thành công
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                // Trả về trang dashboard
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','Tài khoản hoặc mật khẩu không chính xác');
            return Redirect::to('/admin')->with('error','Đăng nhập không thành công');
        }
    }

    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }



    // Đăng nhập với Google
    // public function login_google(){
    //     return Socialite::driver('google')->redirect();
    // }

    // public function callback_google(){
    //     $users = Socialite::driver('google')->stateless()->user();
    //     // return $users->id;
    //     $authUser = $this->findOrCreateUser($users,'google');
    //     $account_name = Login::where('admin_id',$authUser->user)->first();
    //     Session::put('admin_login',$account_name->admin_name);
    //     Session::put('admin_id',$account_name->admin_id);
    //     return Redirect::to('/dashboard')->with('message','Đăng nhập thành công');
    // }

    // public function findOrCreateUser($users,$provider){
    //     $authUser = Social::where('provider_user_id',$users->id)->first();
    //     if($authUser){
    //         return $authUser;
    //     }
    //     $quan = new Social([
    //         'provider_user_id'=>$users->id,
    //         'provider'=>strtoupper($provider)
    //     ]);
    //     $orang = Login::where('admin_mail',$users->email)->first();
    //     if(!$orang){
    //         $orang = Login::create([
    //             'admin_name' => $users->name,
    //             'admin_email' => $users->email,
    //             'admin_password' => '',
    //             'admin_phone' => '',
    //             'admin_status' => 1
    //         ]);
    //     }
    //     $quan->login()->associate($orang);
    //     $quan->save();

    //     $account_name = Login::where('admin_id',$authUser->user)->first();
    //     Session::put('admin_login',$account_name->admin_name);
    //     Session::put('admin_id',$account_name->admin_id);
    //     return Redirect::to('/dashboard')->with('message','Đăng nhập thành công');
    // }


}
