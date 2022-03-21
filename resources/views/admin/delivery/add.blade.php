@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm vận chuyển
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
                        <form role="form" action="{{URL::to('/save-brand')}}" method="POST">
                            {{-- Tự động tạo 1 token khi hoàn thành thêm 1 danh mục sản phẩms --}}
                            @csrf
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn thành phố</label>
                                <select name="city" id="city" class="form-control input-lg m-bot15 choose city">
                                    <option>---Chọn tỉnh, thành phố---</option>
                                    @foreach ($city as $key => $val )
                                        <option value="{{$val['city_id']}}">{{$val['city_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn quận, huyện</label>
                                <select name="province" id="province" class="form-control input-lg m-bot15 choose province">
                                    <option value="">---Chọn quận, huyện---</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn xã, phường</label>
                                <select name="wards" id="wards" class="form-control input-lg m-bot15 wards">
                                    <option value="">---Chọn xã, phường---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phí vận chuyển</label>
                                <input name="fee_ship" type="text" class="form-control fee_ship" id="exampleInputEmail1">
                            </div>
                            <button name="add_delivery" type="button" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                        </form>
                    </div>

                    <div id="load_delivery" style="margin-top: 20px;">
                        
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection