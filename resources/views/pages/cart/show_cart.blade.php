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
                                Session::put('total_order',$total);
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
        <div class="container" style="margin-bottom:15px;">
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Tổng tiền <span>
                                @if (Session::get('cart')==true)
                                    {{number_format($total,0,',','.')}} VND
                                @else
                                    0
                                @endif</span></li>
                            <li>Thuế <span></span></li>
                            <li>Phí vận chuyển <span></span></li>
                            <li>Thành tiền <span></span></li>
                        </ul>
                        @if(Session::get('customer_id'))
                            <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
                        @else
                            <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</section> <!--/#cart_items-->
{{-- <section id="do_action">
    
</section> --}}


@endsection