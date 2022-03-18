<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Yoeunes\Toastr;
use Illuminate\Support\Facades\Mail;
Session_start();

class HomeController extends Controller
{
    // Trang chủ
    public function index(Request $request){
        // --Seo meta
        // $meta_desc = "Chuyên bán quần áo";
        // $meta_keywords = "Quần áo, đồ xuất khẩu";
        // $meta_title = "QK Store";
        // $url_cannical = $request->url();
        // --Seo meta

        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('status','1')->orderBy('id','desc')->limit(3)->get();
        
        return view('pages.home')->with('category',$category)->with('brand',$brand)->with('all_product',$all_product);
        // return view('pages.home')->with(compact('category','brand','all_product','meta_desc','meta_keywords','meta_title','url_cannical'));
        
    }

    // Tìm kiếm sản phẩm
    public function search_product(Request $request){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        
        $keywords = $request->keyword_product;
        $search_pro = DB::table('tbl_product')->where('status','1')->orderBy('id','desc')->where('name','like','%'.$keywords.'%')->get();
        

        return view('pages.products.search_product',compact('category','brand','search_pro'));
        
    }

    public function send_mail(){
        $to_name = "ant";
        $to_email = "anhquannguyen124@gmail.com";//send to this email

        $data = array("name"=>"QK Store ","body"=>"Xác nhận đặt hàng thành công"); //body of mail.blade.php

        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Xác nhận đặt hàng thành công từ QK Store');//send this mail with subject
            $message->from($to_email,$to_name);//send from this mail
        });
        return Redirect::to('/')->with('message','Cảm ơn bạn đã đặt hàng, hãy kiểm tra email để xác thực đặt hàng thành công');
    }
}
