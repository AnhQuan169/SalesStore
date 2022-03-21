<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
use Cart;
Session_start();

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng không dùng Ajax
    // Chưa xử lí
    public function save_cart(Request $request){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $product_id = $request->product_id_hidden;
        $quanlity = $request->qty;

        $data = DB::table('tbl_product')->where('id',$product_id)->get();
        
        return view('pages.cart.show_cart')->with('category',$category)->with('brand',$brand);
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        //Mỗi sản phẩm thêm vào giỏ hàng sẽ tạo ra 1 session_id
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        // Nếu tồn tại sản phẩm bên trong giỏ hàng
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                    $cart[$key] = array(
                        'session_id'=> $session_id,
                        'product_id' =>$data['cart_product_id'],
                        'product_name' => $data['cart_product_name'],
                        'product_image' =>$data['cart_product_image'],
                        'product_qty' =>$val['product_qty']+$data['cart_product_qty'],
                        'product_price' =>$data['cart_product_price']
                    );
                    Session::put('cart',$cart);
                    
                }
            }
            Session::put('cart',$cart);
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

        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.cart.show_cart')->with('category',$category)->with('brand',$brand)
            ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_tile',$meta_tile)
            ->with('url_canonical',$url_canonical);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart){
            // $key là session_id
            // $qty là số lượng của các sản phẩm trong giỏ hàng
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty']=$qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Cập nhật sản phẩm thành công');
        }else{
            return Redirect()->back()->with('error','Cập nhật sản phẩm thất bại');
        }
    }

    // xoá sản phẩm bên trong giỏ hàng
    public function delete_product_ajax($session_id){
        // Lấy tất cả giá trị từ biến cart trong Session
        $cart = Session::get('cart');
        // Nếu tồn tại giá trị bên trong biến cart của Session
        if($cart){
            // Dùng hàm foreach để lướt qua toàn bộ các sản phẩm bên trong cart
            foreach($cart as $key => $val){
                // Nếu session_id của 1 phần tử nào đó tồn tại bên trong cart = session_id của sản phẩm ta chọn để xoá 
                if($val['session_id']==$session_id){
                    // Nó sẽ loại bỏ phần tử tại vị trí với session_id được chọn
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Xoá sản phẩm thành công');
        }else{
            return Redirect()->back()->with('error','Xoá sản phẩm thất bại');
        }
    }

    // Xoá tất cả sản phẩm trong giỏ hàng
    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart){
            // Xoá hết tất cả các Session
            // Session::destroy();
            Session::forget('cart');
            Session::forget('coupon');
            Session::forget('fee');
            return Redirect()->back()->with('message','Xoá sản phẩm thành công');
        }else{
            return Redirect()->back()->with('error','Xoá sản phẩm thất bại');
        }
    }

    // =====================client============================
    // --------------------Mã khuyến mãi------------------
    // Thêm mã khuyến mãi vào giỏ hàng
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                if($coupon_session){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            // Tên đặt => trường trong DB
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        // Tên đặt => trường trong DB
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('message','Thêm mã khuyến mãi thành công');
            }
        }else{
            return redirect()->back()->with('error','Mã khuyến mãi không đúng');
        }
    }

    // Xoá mã khuyến mãi
    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon){
            Session::forget('coupon');
            return Redirect()->back()->with('message','Xoá mã khuyến mãi thành công');
        }
    }
}
