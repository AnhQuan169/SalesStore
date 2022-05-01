<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Products;
// Thư viện cho phép sử dụng Session
use Illuminate\Support\Facades\Session;
// Thư viện cho phép xử lí thông tin dữ liệu khi thành công hoặc thất bại với lệnh
use Illuminate\Support\Facades\Redirect;
use Yoeunes\Toastr;
Session_start();

class BrandController extends Controller
{

    // Bảo mật Login
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    //Mở cửa sổ thêm thương hiệu sản phẩm
    public function add_brand(){
        $this->AuthLogin();
        return view('admin.brand.add');
    }

    //Danh sách thương hiệu sản phẩm
    public function all_brand(){
        $this->AuthLogin();
        // Cách 1: DB: static hướng đối tượng
        // $all_brand = DB::table('tbl_brand')->get();

        // Cách 2: Model
        // $all_brand = Brand::all();
        // + take(3): lấy số lượng sản phẩm mong muốn
        // + paginate(4): In ra số lượng sản phẩm có trong 1 trang
        $all_brand = Brand::orderBy('brand_id','DESC')->get();
        
        $manager_brand = view('admin.brand.all')->with('all_brand',$all_brand);
        return view('admin_layout')->with('admin.all_brand',$manager_brand);
    }

    // Lưu thương hiệu sản phẩm được thêm mới vào
    public function save_brand(Request $request){
        // Cách 1: Dùng DB tạo từ Migrate bình thường
        // $this->AuthLogin();
        // $data = array();
        // // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        // $data['brand_name'] = $request->brand_name;
        // $data['brand_desc'] = $request->brand_desc;
        // $data['brand_status'] = $request->brand_status;
        // DB::table('tbl_brand')->insert($data);

        // Cách 2: Dùng Model
        $data = $request->all();
        $brand = new Brand();
        // $brand->Các trường bên trong model = $data['các name của các input']
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->brand_status = $data['brand_status'];
        $brand->save();

        Session::put('message','Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('/add-brand');
    }

    // Hiển thị thương hiệu sản phẩm được chọn
    public function active_brand($brand_id){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status'=>1]);
        Session::put('message','Kích hoạt trạng thái thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand');
    }

    // Ẩn thương hiệu sản phẩm được chọn
    public function unactive_brand($brand_id){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status'=>0]);
        Session::put('message','Không kích hoạt trạng thái thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand');
    }

    //Mở cửa sổ cập nhật thương hiệu sản phẩm được chọn
    public function edit_brand($brand_id){
        $this->AuthLogin();
        // Cách 1: DB
        // $edit_brand = DB::table('tbl_brand')->where('brand_id',$brand_id)->get();
        
        // Cách 2: Model
        // + Sử dụng hàm find() chỉ có thể cho ra 1 sản phẩm tương ứng với brand_id
        $edit_brand = Brand::find($brand_id);
        //  Cách 2.1 : Sử dụng Model nhưng có thể sử dụng foreach để truyền thông tin 
        // $edit_brand = Brand::where('brand_id',$brand_id)->get();

        $manager_brand = view('admin.brand.edit')->with('edit_brand',$edit_brand);
        return view('admin_layout')->with('admin.edit_brand',$manager_brand);  
    }

    // Lưu thông tin chỉnh sửa với thương hiệu san phẩm được chọn
    public function update_brand(Request $request,$brand_id){
        $this->AuthLogin();
        // Cách 1: DB
        // $data = array();
        // // Cú pháp: $data['tên của trường bên trong mysql] = $request->name của input lấy được từ code giao diện
        // $data['brand_name'] = $request->brand_name;
        // $data['brand_desc'] = $request->brand_desc;
        // $data['brand_status'] = $request->brand_status;
        // DB::table('tbl_brand')->where('brand_id',$brand_id)->update($data);

        // Cách 2: Model
        $data = $request->all();
        $brand = Brand::find($brand_id);
        // $brand->Các trường bên trong model = $data['các name của các input']
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->brand_status = $data['brand_status'];
        $brand->save();

        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand');
    }

    //Xoá thương hiệu sản phẩm
    public function delete_brand($brand_id){
        $this->AuthLogin();
        // DB::table('tbl_brand')->where('brand_id',$brand_id)->delete();
        // $br_pro = DB::table('tbl_brand')->where('brand_id',$brand_id)->get();
        // $pro_pro = DB::table('tbl_product')
        //     ->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
        //     ->where('tbl_product.brand_id',$brand_id)->get();
        $br_pro = Brand::where('brand_id',$brand_id)->count();
        $pro_pro = Products::where('brand_id',$brand_id)->count();
        if($br_pro > 0 && $pro_pro> 0){
            Session::put('message','Danh sách sản phẩm chứa sản phẩm có thương hiệu này, không thể xoá');
            return Redirect::to('/all-brand');
        }
        else{
            Brand::find($brand_id)->delete();
            Session::put('message','Xoá thương hiệu sản phẩm thành công');
            return Redirect::to('/all-brand');
        }
        // if(Brand::find($brand_id)==Products::find($brand_id))
        
    }


    //---------------Client---------------------
    // Hiển thị sản phẩm theo thương hiệu sản phẩm được chọn
    public function show_Brand_Home(Request $request,$brand_id){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();

        $brand_by_id = DB::table('tbl_product')
            ->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
            ->where('tbl_product.brand_id',$brand_id)->get();

        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get();

        // foreach($brand_name as $key => $val){
        //     // --Seo meta
        //     $meta_desc = $val->brand_desc;
        //     $meta_keywords = $val->brand_name;
        //     $meta_title = $val->brand_name;
        //     $url_cannical = $request->url();
        //     // --Seo meta
        // }
        // return view('pages.brand.show_brand',compact('category','brand','brand_by_id','brand_name','meta_desc','meta_keywords','meta_title','url_cannical'));

        return view('pages.brand.show_brand')->with('category',$category)->with('brand',$brand)
            ->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name);
    }
}
