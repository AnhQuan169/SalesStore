@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm mới
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <?php 
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">',$message,'</span>';
                                Session::put('message', null);
                            }

                        ?>
                        <form role="form" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
                            {{-- Tự động tạo 1 token khi hoàn thành thêm 1 danh mục sản phẩms --}}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input data-validation="length" data-validation-length="min1" data-validation-error-msg="Hãy điền tên sản phẩm" name="product_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select name="category_pro" class="form-control input-lg m-bot15">
                                    @foreach ($cate_product as $key => $cate )
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                <select name="brand_pro" class="form-control input-lg m-bot15">
                                    @foreach ($brand_product as $key => $brand )
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea style="resize: none" rows="5" name="product_desc"  class="form-control" id="ckeditor1" required  placeholder="Mô tả thương hiệu"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea  style="resize: none" rows="5" name="product_content" class="form-control" id="ckeditor2" placeholder="Nội dung thương hiệu"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" data-validation="number" data-validation-allowing="range[1000;10000000]" data-validation-error-msg="Hãy điền giá của sản phẩm (Lớn hơn 1.000 VND và nhỏ hơn 10 triệu VND)" name="product_price" type="text" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" multiple="multiple" data-validation="length size" 
                                    data-validation-length="min1" data-validation-error-msg-length="Hãy chọn 1 ảnh sản phẩm" 
                                    data-validation-max-size="512kb" data-validation-error-msg-size="Hãy chọn ảnh sản phẩm có kích thước < 512KB"
                                    name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tình trạng</label>
                                <select name="product_status" class="form-control input-lg m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">HIển thị</option>
                                </select>
                            </div>
                            <button name="add_product" type="submit" class="btn btn-info">Thêm sản phẩm</button>
                        </form>
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection