<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Yoeunes\Toastr;
Session_start();

class OrderController extends Controller
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

    //Hiển thị danh sách đơn hàng
    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.id','=','tbl_order.customer_id')
        ->select('tbl_order.*','tbl_customer.name')
        ->orderBy('tbl_order.order_id','desc')->get();
        $manage_order = view('admin.orders.manage_order')->with('all_order',$all_order);
        
        return view('admin_layout')->with('admin.all_order',$manage_order);
    }

    // Hiển thị chi tiết đơn hàng
    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.id','=','tbl_order.customer_id')
        ->join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')
        ->where('tbl_order.order_id',$order_id)
        ->first();

        $order_list = DB::table('tbl_order')
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')->where('tbl_order.order_id',$order_id)->get();

        $manage_order_by_id = view('admin.orders.view_order')->with('order_by_id',$order_by_id)->with('order_list',$order_list);
        
        return view('admin_layout')->with('admin.view_order',$manage_order_by_id);
    }
}
