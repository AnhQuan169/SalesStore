@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <form action="{{URL::to('/update-cart')}}" method="POST">
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
                                        
                                        <input class="cart_quantity" type="number" name="quantity" min="1" value="{{$pro['product_qty']}}">
                                        
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">{{number_format($subtotal,0,',','.')}} VND</p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            
                        @endforeach
                        <tr>
                            <td>
                                <input type="submit" class="check_out cart_quantity_down" href="" value="Cập nhật giỏ hàng" />
                            </td>
                        </tr>
                    </tbody>                                        
                </table>
            </form>
        </div>
    </div>
</section> <!--/#cart_items-->
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền <span></span></li>
                        <li>Thuế <span></span></li>
                        <li>Phí vận chuyển <span></span></li>
                        <li>Tiền sau giảm <span></span></li>
                    </ul>
                    <a class="btn btn-default check_out" href="">Thanh toán</a>
                    <a class="btn btn-default check_out" href="">Tính mã giảm giá</a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection