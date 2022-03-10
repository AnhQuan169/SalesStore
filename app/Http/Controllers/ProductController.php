<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Yoeunes\Toastr;
Session_start();

class ProductController extends Controller
{
    // Mở cửa sổ thêm sản phẩm mới
    public function add_product(){
        // Lấy dữ liệu từ 2 table danh mục, thương hiệu sản phẩm và sắp xếp theo id với orderBy
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();       
        $brand_product = DB::table('tbl_brand')->orderBy('brand_id','desc')->get();

        // ->with('Tên khai báo để phía cần thì gọi lại',biến được khai báo chứa giá trị ở phía trên)
        return view('admin.product.add')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }

    // Hiển thị trang danh sách sản phẩm
    public function all_product(){
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderBy('tbl_product.id','desc')->get();
        $manage_product = view('admin.product.all')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.all_product',$manage_product);
    }

    // Hiển thị  sản phẩm được chọn
    public function active_product($product_id){
        DB::table('tbl_product')->where('id',$product_id)->update(['status'=>1]);
        Session::put('message','Kích hoạt trạng thái sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    // Ẩn sản phẩm được chọn
    public function unactive_product($product_id){
        DB::table('tbl_product')->where('id',$product_id)->update(['status'=>0]);
        Session::put('message','Không kích hoạt trạng thái sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    //Lưu thông tin sản phẩm mới đã thêm
    public function save_product(Request $request){
        $data = array();

        $data['name'] = $request->product_name;
        $data['category_id'] = $request->category_pro;
        $data['brand_id'] = $request->brand_pro;
        $data['desc'] = $request->product_desc;
        $data['content'] = $request->product_content;
        $data['price'] = $request->product_price;
        $data['status'] = $request->product_status;

        // Uploads ảnh khi thêm sản phẩm mới
        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            // Sử dụng hàm Explode() để phân tách thành 2 giá trị từ 1 giá trị với vị trị phân tách tại '.'
            // Khi dùng explode() tách biến thành 2 giá trị rồi
            //  + Sử dụng hàm current() để lấy giá trị đầu của của biến được phân tách
            //  + Sử dụng hàm end() để lấy giá trị cuối của biến được phân tách
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/products',$new_image);
            $data['image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm mới thành công');
            return Redirect::to('/add-product');
        }
        $data['image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm mới thành công');
        return Redirect::to('/add-product');
  
    }

    // Hiển thị cửa số chỉnh sửa sản phẩm được chọn
    public function edit_product($product_id){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();       
        $brand_product = DB::table('tbl_brand')->orderBy('brand_id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('id',$product_id)->get();

        $manage_product = view('admin.product.edit')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product',$manage_product);
    }

    //Cập nhật thông tin sản phẩm được chọn
    public function update_product(Request $request, $product_id){
        $data = array();
        // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        $data['name'] = $request->product_name;
        $data['category_id'] = $request->category_pro;
        $data['brand_id'] = $request->brand_pro;
        $data['desc'] = $request->product_desc;
        $data['content'] = $request->product_content;
        $data['price'] = $request->product_price;
        $data['status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            // Sử dụng hàm Explode() để phân tách thành 2 giá trị từ 1 giá trị với vị trị phân tách tại '.'
            // Khi dùng explode() tách biến thành 2 giá trị rồi
            //  + Sử dụng hàm current() để lấy giá trị đầu của của biến được phân tách
            //  + Sử dụng hàm end() để lấy giá trị cuối của biến được phân tách
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/products',$new_image);
            $data['image'] = $new_image;
            DB::table('tbl_product')->where('id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('/all-product');
        }
        DB::table('tbl_product')->where('id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    // Xoá sản phẩm 
    public function delete_product($product_id){
        DB::table('tbl_product')->where('id',$product_id)->delete();
        Session::put('message','Xoá sản phẩm thành công');
        return Redirect::to('/all-product');
    }


}
