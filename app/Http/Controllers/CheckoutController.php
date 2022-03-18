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
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.login_chekout')->with('category',$category)->with('brand',$brand);
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
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        if(Session::get('cart')){
            return view('pages.checkout.show_checkout')->with('category',$category)->with('brand',$brand);
        }else{
            // Session::put('message','Hãy chọn sản phẩm trước khi thanh toán');
            // return view('pages.cart.show_cart')->with('category',$category)->with('brand',$brand)->with('message','Hãy chọn sản phẩm trước khi thanh toán');
            return Redirect()->back()->with('error','Hãy chọn sản phẩm trước khi thanh toán');
        }
    }

    // Lưu thông tin người nhận đơn hàng
    // Thông tin trong table tbl_shipping
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->name;
        $data['shipping_email'] = $request->email;
        $data['shipping_address'] = $request->address;
        $data['shipping_phone'] = $request->phone;
        $data['shipping_note'] = $request->note;

        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        
        return Redirect('/payment');
    }

    // Giao diện chọn hình thức thanh toán
    public function payment(){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.payment')->with('category',$category)->with('brand',$brand);
    
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
        $payment_data['payment_method'] = $request->payment_option;
        // 1: Đang chờ xử lí
        $payment_data['payment_status'] = 1;
        // Ngay sau khi insert dữ liệu vào table tbl_customer
        // - Dữ liệu sẽ được insert vào biến $insert_customer 
        // - Do sử dụng hàm insertGetId()
        $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

        // ---------Áp dụng vào tbl_order-------------
        // Insert vào order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Session::get('total_order');
        $order_data['order_status'] = 1;
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        
        // ---------Áp dụng vào tbl_order_details-------------
        // Insert vào order
        $cart = Session::get('cart');
        $order_details_data = array();
        foreach($cart as $key => $pro){
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $pro['product_id'];
            $order_details_data['order_detail_name'] = $pro['product_name'];
            $order_details_data['order_detail_price'] = $pro['product_price'];
            $order_details_data['order_detail_quantity'] = $pro['product_qty'];
            DB::table('tbl_order_details')->insert($order_details_data);
        }
        Session::forget('cart');
        if($payment_data['payment_method']==1){
            return Redirect::to('/send-mail')->with('message','Cảm ơn bạn đã đặt hàng, chúng tôi sẽ liên hệ với bạn sớm nhất có thể');
        }elseif($payment_data['payment_method']==2){
            return Redirect::to('/send-mail')->with('message','Cảm ơn bạn đã đặt hàng, chúng tôi sẽ liên hệ với bạn sớm nhất có thể');
        }else{
            return Redirect::to('/send-mail')->with('message','Cảm ơn bạn đã đặt hàng, chúng tôi sẽ liên hệ với bạn sớm nhất có thể');
        }

        // return Redirect('/')->with('message','Đặt hàng thành công');
    }
}
