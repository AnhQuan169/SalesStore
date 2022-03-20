@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
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
                        <form role="form" action="{{URL::to('/save-coupon')}}" method="POST">
                            {{-- Tự động tạo 1 token khi hoàn thành thêm 1 danh mục sản phẩms --}}
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                <input name="coupon_name" type="text" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã giảm giá</label>
                                <input name="coupon_code" type="text" class="form-control" id="exampleInputEmail1">                            
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng mã</label>
                                <input name="coupon_time" type="text" class="form-control" id="exampleInputEmail1">                            
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tính năng mã</label>
                                <select name="coupon_condition" class="form-control input-lg m-bot15">
                                    <option value="0">-------Chọn-------</option>
                                    <option value="1">Giảm theo phần trăm</option>
                                    <option value="2">Giảm theo tiền</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhập số % hoặc tiền giảm</label>
                                <input name="coupon_number" type="text" class="form-control" id="exampleInputEmail1">                            
                            </div>
                            <button name="add_coupon" type="submit" class="btn btn-info">Thêm mã giảm giá</button>
                        </form>
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection