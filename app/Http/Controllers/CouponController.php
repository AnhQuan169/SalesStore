<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
    //
    public function add_coupon(){
        return view('admin.coupon.add');
    }

    // Thêm mã khuyến mãi mới thêm vào DB
    public function save_coupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon();
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();
        Session::put('message','Thêm mã khuyến mãi mới thành công');
        return Redirect::to('/add-coupon');
    }

    // Hiển thị danh sách mã giảm giá
    public function all_coupon(){
        $coupon_list = Coupon::orderBy('coupon_id','desc')->get();
        return view('admin.coupon.all', compact('coupon_list'));
    }

    // Xoá mã giảm giá
    public function delete_coupon(Request $request,$coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Xoá mã khuyến mãi thành công');
        return Redirect::to('/all-coupon');
    }
}
