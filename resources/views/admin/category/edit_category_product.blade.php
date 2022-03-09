@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
                </header>
                <div class="panel-body">
                    @foreach ($edit_category_product as$key => $edit_value )
                        
                    <div class="position-center">
                        <?php 
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">',$message,'</span>';
                                Session::put('message', null);
                            }

                        ?>
                        <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="POST">
                            {{-- Tự động tạo 1 token khi hoàn thành thêm 1 danh mục sản phẩms --}}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input value="{{$edit_value->category_name}}" name="category_product_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea style="resize: none" rows="5" name="category_product_desc" type="password" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$edit_value->category_desc}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tình trạng</label>
                                <select name="category_product_status" class="form-control input-lg m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">HIển thị</option>
                                </select>
                            </div>
                            <button name="update_category_product" type="submit" class="btn btn-info">Cập nhật danh mục</button>
                        </form>
                    </div>
                    @endforeach

                </div>
            </section>

    </div>
</div>
@endsection