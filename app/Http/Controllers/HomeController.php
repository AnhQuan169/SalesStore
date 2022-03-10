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

class HomeController extends Controller
{
    // Trang chủ
    public function index(){

        $cate_pro = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_pro = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('status','1')->orderBy('id','desc')->limit(3)->get();
        

        return view('pages.home')->with('category',$cate_pro)->with('brand',$brand_pro)->with('all_product',$all_product);
    }
}
