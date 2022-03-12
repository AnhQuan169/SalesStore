<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Cart;
Session_start();

class CartController extends Controller
{
    //
    public function save_cart(Request $request){
        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $product_id = $request->product_id_hidden;
        $quanlity = $request->qty;

        $data = DB::table('tbl_product')->where('id',$product_id)->get();
        
        return view('pages.cart.show_cart')->with('category',$cate_pro)->with('brand',$brand_pro);
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        print_r($data);
        //Mỗi sản phẩm thêm vào giỏ hàng sẽ tạo ra 1 session_id
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        // Nếu tồn tại sản phẩm bên trong giỏ hàng
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            // Nếu sản phẩm mới được thêm vào không trùng với sản phẩm nào đã tồn tại bên trong giỏ hàng
            if($is_avaiable==0){
                $cart[] = array(
                    'session_id'=> $session_id,
                    'product_id' =>$data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' =>$data['cart_product_image'],
                    'product_qty' =>$data['cart_product_qty'],
                    'product_price' =>$data['cart_product_price']
                );
                Session::put('cart',$cart);
            }
        }else{
            // Nếu chưa tồn tại biến cart, tức là chưa tồn tại giá trị bên trong giỏ hàng
            // Các giá trị của sản phẩm sẽ được add với việc lấy dữ liệu từ AJAX qua việc nhấn chọn thêm vào giỏ hàng
            $cart[] = array(
                'session_id'=> $session_id,
                'product_id' =>$data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' =>$data['cart_product_image'],
                'product_qty' =>$data['cart_product_qty'],
                'product_price' =>$data['cart_product_price']
            );
            Session::put('cart',$cart);
        }
        // Chọn dù chưa/tồn tại giá trị bên trong cart
        // + Nhưng ta vẫn put dữ liệu của sản phẩm được chọn thêm vào giỏ hàng lên Session
        // Session::put('cart',$cart);
        Session::save();
    }

    public function show_cart(Request $request){
        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng Ajax";
        $meta_tile = "Giỏ hàng Ajax";
        $url_canonical = $request->url();

        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.cart.show_cart')->with('category',$cate_pro)->with('brand',$brand_pro)
            ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_tile',$meta_tile)
            ->with('url_canonical',$url_canonical);
    }

    // public function update_cart(){

    // }
}
