<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;

class UserController extends Controller
{
    //
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id','desc')->paginate(5);
        return view('admin.user.all')->with(compact('admin'));
    }

    // Thêm quyền cho người dùng
    public function assign_roles(Request $request){

        $user = Admin::where('admin_mail',$request->admin_email)->first();
        $user->roles()->detach();
        if($request->author_role){
            $user->roles()->attach(Roles::where('name','author')->first());
        }
        if($request->admin_role){
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        if($request->user_role){
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        return redirect()->back()->with('message','Cấp quyền thành công');
    }
}
