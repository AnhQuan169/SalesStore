@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Thông tin khách hàng
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ email</th>
                    <th>Số điện thoại</th>
                    <th style="width:30px;"></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$order_by_id->name}}</td>
                        <td>{{$order_by_id->email}}</td>
                        <td>{{$order_by_id->phone}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br />
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Thông tin người nhận
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Tên người nhận</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$order_by_id->shipping_name}}</td>
                        <td>{{$order_by_id->shipping_address}}</td>
                        <td>{{$order_by_id->shipping_phone}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br />
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Chi tiết đơn hàng
        </div>
        <div class="row w3-res-tb">
            <?php 
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    Session::put('message', null);
                }

            ?>
            
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($order_list as $key => $item)
                        <tr>
                            <td>{{$item->order_detail_name}}</td>
                            <td>{{$item->order_detail_quantity}}</td>
                            <td>{{number_format($item->order_detail_price,0,',','.')}} VND</td>
                            <td>{{number_format(($item->order_detail_quantity*$item->order_detail_price),0,',','.')}} VND</td>
                        </tr>
                    @endforeach
                    <tr style="font-size: 22px;background-color: #dee4ef;">
                        <td></td>
                        <td></td>
                        <td style="color: green">Thành tiền:</td>
                        <td style="color: green">{{number_format($order_by_id->order_total,0,',','.')}} VND</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

@endsection