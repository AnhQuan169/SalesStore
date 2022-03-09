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
    //Mở cửa sổ thêm danh mục sản phẩm
    public function add_category_product(){
        return view('admin.category.add_category_product');
    }

    //Danh sách danh mục sản phẩm
    public function all_category_product(){
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.category.all_category_product')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }

    // Lưu danh mục sản phẩm được thêm mới vào
    public function save_category_product(Request $request){
        
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
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Kích hoạt trạng thái danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    // Ẩn danh mục sản phẩm được chọn
    public function unactive_category_product($category_product_id){
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Không kích hoạt trạng thái danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    //Mở cửa sổ cập nhật danh mục sản phẩm được chọn
    public function edit_category_product($category_product_id){
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.category.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);  
    }

    // Lưu thông tin chỉnh sửa với danh mục san phẩm được chọn
    public function update_category_product(Request $request,$category_product_id){
        $data = array();
        // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');

    }

}
