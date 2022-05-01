<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class UserController extends Controller
{
    //
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id','desc')->paginate(5);
        return view('admin.user.all')->with(compact('admin'));
    }

    // Thêm quyền cho người dùng
    public function assign_roles(){
        
    }
}
