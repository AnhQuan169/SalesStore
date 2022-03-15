@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                    @foreach ($edit_brand as $key => $edit_value )
                        
                    <div class="position-center">
                        <?php 
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">',$message,'</span>';
                                Session::put('message', null);
                            }

                        ?>
                        <form role="form" action="{{URL::to('/update-brand/'.$edit_value->brand_id)}}" method="POST">
                            {{-- Tự động tạo 1 token khi hoàn thành thêm 1 thương hiệu sản phẩms --}}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input data-validation="length" data-validation-length="min1" data-validation-error-msg="Hãy điền tên thương hiệu sản phẩm" value="{{$edit_value->brand_name}}" name="brand_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows="5" name="brand_desc" type="password" class="form-control" id="ckeditor8" placeholder="Mô tả thương hiệu">{{$edit_value->brand_desc}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tình trạng</label>
                                <select name="brand_status" class="form-control input-lg m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">HIển thị</option>
                                </select>
                            </div>
                            <button name="update_brand" type="submit" class="btn btn-info">Cập nhật thương hiệu</button>
                        </form>
                    </div>
                    @endforeach

                </div>
            </section>

    </div>
</div>
@endsection