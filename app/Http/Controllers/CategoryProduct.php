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

class CategoryProduct extends Controller
{
    // ------------Admin------------
    // Bảo mật Login
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    //Mở cửa sổ thêm danh mục sản phẩm
    public function add_category_product(){
        $this->AuthLogin();
        return view('admin.category.add_category_product');
    }

    //Danh sách danh mục sản phẩm
    public function all_category_product(){
        $this->AuthLogin();
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.category.all_category_product')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }

    // Lưu danh mục sản phẩm được thêm mới vào
    public function save_category_product(Request $request){
        $this->AuthLogin();
        $data = array();
        // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        
        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('/add-category-product');
    }

    // Hiển thị danh mục sản phẩm được chọn
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Kích hoạt trạng thái danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    // Ẩn danh mục sản phẩm được chọn
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Không kích hoạt trạng thái danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    //Mở cửa sổ cập nhật danh mục sản phẩm được chọn
    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.category.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);  
    }

    // Lưu thông tin chỉnh sửa với danh mục san phẩm được chọn
    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $data = array();
        // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    //Xoá danh mục sản phẩm
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }


    //------------Client-------------
    // Hiển thị sản phẩm theo danh mục sản phẩm được chọn
    public function show_Category_Home(Request $request,$category_id){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $category_by_id = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
            ->where('tbl_product.category_id',$category_id)->get();

        $cate_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();

        // foreach($cate_name as $key => $val){
        //     // --Seo meta
        //     $meta_desc = $val->category_desc;
        //     $meta_keywords = $val->category_name;
        //     $meta_title = $val->category_name;
        //     $url_cannical = $request->url();
        //     // --Seo meta
        // }
        // return view('pages.category.show_category')->with(compact('category','brand','category_by_id','cate_name','meta_desc','meta_keywords','meta_title','url_cannical'));

        return view('pages.category.show_category')->with('category',$category)->with('brand',$brand)
            ->with('category_by_id',$category_by_id)->with('cate_name',$cate_name);
    }


}
