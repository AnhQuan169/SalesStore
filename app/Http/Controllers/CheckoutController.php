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
        $data['password'] = md5($request->password);
        $data['phone'] = $request->phone;

        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->name);

        if(Session::get('cart')){
            return Redirect::to('/show-cart');
        }else{
            return Redirect::to('/');
        }
    }

    //Mở giao diện trang nhập thông tin người nhận
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

    // Thanh toán đơn hàng
    public function payment(){
        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.payment')->with('category',$cate_pro)->with('brand',$brand_pro);
    
    }

    // Đăng xuất
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    // Đăng nhập vào tài khoản khách hàng
    public function login_customer(Request $request){
        $email=$request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('email',$email)->where('password',$password)->first();
        
        if($result && Session::get('cart')){
            Session::put('customer_id',$result->id);
            Session::put('customer_name',$result->name);
            return Redirect::to('/show-cart');
        }
        elseif($result && Session::get('cart')==null){
            Session::put('customer_id',$result->id);
            Session::put('customer_name',$result->name);
            return Redirect::to('/');
        }
        else{
            return Redirect::to('/login-checkout');
        }
    }

    // Chọn hình thức thanh toán đơn hàng và hoàn thành đặt hàng
    public function order_place(Request $request){
        // ----------Áp dụng vào tbl_payment----------------
        // insert payment_method
        $payment_data = array();
        $data['method'] = $request->payment_option;
        // 1: Đang chờ xử lí
        $data['status'] = 1;
        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        // ---------Áp dụng vào tbl_order-------------
        // Insert vào order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['total'] = Session::get('total_order');
        $order_data['status'] = 1;
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        
        // ---------Áp dụng vào tbl_order_details-------------
        // Insert vào order
        $cart = Session::get('cart');
        $order_details_data = array();
        foreach($cart as $key => $pro){
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $pro['product_id'];
            $order_details_data['name'] = $pro['product_name'];
            $order_details_data['price'] = $pro['product_price'];
            $order_details_data['quantity'] = $pro['product_qty'];
            DB::table('tbl_order_details')->insert($order_details_data);
        }
        Session::forget('cart');

        return Redirect('/')->with('message','Đặt hàng thành công');
    }
}
