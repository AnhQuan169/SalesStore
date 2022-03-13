<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    //Hiển thị trang login khi nhấn nút thanh toán trong khi chưa có tài khoản
    public function login_checkout(){
        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.login_chekout')->with('category',$cate_pro)->with('brand',$brand_pro);
    }

    // Đăng kí tài khoản cho khách hàng
    // Dữ liệu được thêm vào tbl_customer
    public function add_customer(Request $request){
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['phone'] = $request->phone;

        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->name);
        
        return Redirect('/checkout');
    }

    //Mở giao diện trang thanh toán giỏ hàng
    public function checkout(){
        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')->with('category',$cate_pro)->with('brand',$brand_pro);
    }

    // Lưu thông tin người nhận đơn hàng
    // Thông tin trong table tbl_shipping
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['note'] = $request->note;

        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        
        return Redirect('/payment');
    }

    public function payment(){

    }
}
