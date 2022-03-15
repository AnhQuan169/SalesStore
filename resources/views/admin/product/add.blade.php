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
                                <input name="product_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu sản phẩm">
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
                                <textarea style="resize: none" rows="5" name="product_desc"  class="form-control" id="ckeditor1" placeholder="Mô tả thương hiệu"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea style="resize: none" rows="5" name="product_content" class="form-control" id="ckeditor2" placeholder="Nội dung thương hiệu"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input name="product_price" type="text" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input name="product_image" type="file" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh">
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