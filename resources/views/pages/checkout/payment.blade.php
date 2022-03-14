@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <form action="{{URL::to('/update-cart')}}" method="POST">
                @csrf
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh</td>
                            <td class="name">Sản phẩm</td>
                            <td class="price">Đơn giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(Session::get('cart')==true)
                            @php
                                $total =0;
                            @endphp
                            @foreach (Session::get('cart') as $key => $pro )
                            @php
                                $subtotal = $pro['product_price']*$pro['product_qty'];
                                $total += $subtotal;
                            @endphp
                                <tr>
                                    <td class="cart_product">
                                        <a href="{{URL::to('/detail-product/'.$pro['product_id'])}}"><img src="{{URL::to('public/uploads/products/'.$pro['product_image'])}}" alt="" width="200px"></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{$pro['product_name']}}</a></h4>
                                        <p>Web ID: {{$pro['product_id']}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{number_format($pro['product_price'],0,',','.')}} VND</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            
                                            <input class="cart_quantity" type="number" name="cart_qty[{{$pro['session_id']}}]" min="1" value="{{$pro['product_qty']}}">
                                            
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">{{number_format($subtotal,0,',','.')}} VND</p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete" href="{{URL::to('/delete-product-ajax/'.$pro['session_id'])}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                
                            @endforeach
                            <tr>
                                <td>
                                    <input type="submit" class="btn btn-default check_out cart_quantity_down" href="" value="Cập nhật giỏ hàng" />
                                </td>
                                <td>
                                    <a class="btn btn-default check_out" href="{{URL::to('/delete-all-product')}}">Xoá tất cả sản phẩm</a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center;padding-top: 10px;">
                                    @php
                                        echo "Giỏ hàng trống";
                                    @endphp
                                </td>
                            </tr>
                        @endif
                    </tbody>                                        
                </table>
            </form>
        </div>
        <h4 style="margin:40px 0;font-size:20px">Chọn hình thức thanh toán</h4>
        <form action="{{URL::to('/order-place')}}" method="POST" style="height:auto">
            {{ csrf_field() }}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="radio"> Trả bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="radio"> Nhận tiền mặt</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="radio"> Paypal</label>
                </span>
            </div>
            <input style="margin-bottom: 30px;" name="send_order_place" type="submit" class="btn btn-primary btn-sm" value="Đặt hàng" />

        </form>
        
    </div>
</section> <!--/#cart_items-->

@endsection