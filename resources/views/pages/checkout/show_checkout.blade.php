@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Thông tin người nhận</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="register-req">
            <p>Đăng kí hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử giao dịch</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                
                <div class="col-sm-8 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin gửi hàng</p>
                        <div class="form-one">
                            <form method="POST">
                                @csrf
                                <input type="email" name="email" class="shipping_email" placeholder="Email *">
                                <input type="text" name="name" class="shipping_name" placeholder="Họ và tên *">
                                <input type="text" name="address" class="shipping_address" placeholder="Địa chỉ *">
                                <input type="number" name="phone" class="shipping_phone" placeholder="Số điện thoại *">
                                <textarea name="note" class="shipping_note"  placeholder="Ghi chú đơn hàng của bạn" rows="5" ></textarea>		
                                @if(Session::get('coupon'))
                                    @foreach (Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="order_coupon" class="order_coupon" value="0">
                                @endif
                                @if(Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                                @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="10000">
                                @endif
                                <input type="hidden" name="order_fee" class="order_fee">
                                <div class="">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn phương thức thanh toán</label>
                                        <select name="payment_select" class="form-control input-lg m-bot15 payment_select">
                                            <option>---Chọn phương thức thanh toán---</option>
                                            <option value="1">Trả bằng thẻ ATM</option>
                                            <option value="2">Trả bằng tiền mặt</option>
                                            <option value="3">Paypal</option>
                                        </select>
                                    </div>
                                </div>
                                <input name="send_order" type="button" class="btn btn-primary btn-sm send_order" value="Xác nhận đơn hàng" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 clearfix">
                    <div class="bill-to">
                        <p>Chọn địa chỉ vận chuyển</p>
                        <form>
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
                                    <option value="">---Chọn xã, phường, thị trấn---</option>
                                </select>
                            </div>
                            
                            <input name="calculator_order" type="button" class="btn btn-primary btn-sm calculator_delivery" value="Tính phí vận chuyển" />
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 clearfix">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{session()->get('message')}}
                        </div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-danger">
                            {{session()->get('error')}}
                        </div>
                    @endif
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
                                                    <a href="{{URL::to('/detail-product/'.$pro['product_id'])}}"><img src="{{URL::to('public/uploads/products/'.$pro['product_image'])}}" alt="" width="150px"></a>
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
                                            <td>
                                                @if(Session::get('coupon'))
                                                    <a class="btn btn-default check_out" href="{{URL::to('/unset-coupon')}}">Xoá mã khuyến mãi</a>
                                                @endif
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
                                        <li>Tổng tiền: <span>
                                            @if (Session::get('cart')==true)
                                                {{number_format($total,0,',','.')}} VND
                                            @else
                                                0
                                            @endif</span>
                                        </li>
                                        @if(Session::get('coupon'))
                                            @foreach (Session::get('coupon') as $key => $val)
                                                @if($val['coupon_condition']==1)
                                                    <li>Mã giảm: 
                                                        <span>{{$val['coupon_number']}} % 
                                                            <a class="cart_quantity_delete" href="{{URL::to('/unset-coupon')}}"><i class="fa fa-times"></i></a>
                                                        </span>
                                                    </li>
                                                    <li>Tổng giảm: <span>
                                                        @php
                                                            $total_coupon = ($total*$val['coupon_number'])/100;
                                                            $total_after_coupon = $total-$total_coupon;
                                                        @endphp
                                                            {{number_format($total_coupon,0,',','.')}} VND
                                                        </span>
                                                    </li>
                                                    {{-- <li>Tiền sau giảm: <span>{{number_format($total_after_coupon,0,',','.')}} VND</span></li> --}}
                                                @elseif($val['coupon_condition']==2)
                                                    <li>Mã giảm: 
                                                        <span>{{number_format($val['coupon_number'],0,',','.')}} VND
                                                            <a class="cart_quantity_delete" href="{{URL::to('/unset-coupon')}}"><i class="fa fa-times"></i></a>
                                                        </span>
                                                    </li>
                                                    {{-- <li>Tổng giảm: <span> --}}
                                                        @php
                                                            $total_coupon = $val['coupon_number'];
                                                            $total_after_coupon = $total-$total_coupon;
                                                        @endphp
                                                        {{-- </span> --}}
                                                    {{-- </li> --}}
                                                    {{-- <li>Tiền sau giảm: <span>{{number_format($total_after_coupon,0,',','.')}} VND</span></li> --}}
                                                @endif
                                            @endforeach
                                        @endif
                                        @if(Session::get('fee'))
                                            <li>Phí vận chuyển 
                                                <span>{{number_format(Session::get('fee'),0,',','.')}} VND
                                                    <a class="cart_quantity_delete" href="{{URL::to('/delete-fee')}}"><i class="fa fa-times"></i></a>
                                                </span>
                                            </li>
                                        @endif
                                        <li>Thành tiền 
                                            <span>
                                                @if(Session::get('coupon'))
                                                    @php
                                                        $total_after = $total + Session::get('fee') - $total_coupon;
                                                    @endphp
                                                    {{number_format($total_after,0,',','.')}} VND
                                                @else
                                                    @php
                                                        $total_after = $total + Session::get('fee');
                                                    @endphp
                                                    {{number_format($total_after,0,',','.')}} VND
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        @if(Session::get('cart'))
                                            <form method="POST" action="{{URL::to('/check-coupon')}}">
                                                @csrf
                                                <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá" style="width: 200px;display:inline-block;"/>
                                                <input type="submit" name="check_coupon" class="btn btn-success check_coupon" href="{{URL::to('/')}}" value="Tính mã khuyến mãi" />
                                                
                                            </form>
                                        @endif
                                    </ul>
                                    <ul>
                                        @if(Session::get('customer_id'))
                                            <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
                                        @else
                                            <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                                        @endif
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section> <!--/#cart_items-->

@endsection