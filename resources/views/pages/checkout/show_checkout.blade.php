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
                
                <div class="col-sm-10 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin gửi hàng</p>
                        <div class="form-one">
                            <form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                                {{ csrf_field() }}
                                <input type="email" name="email" placeholder="Email *">
                                <input type="text" name="name" placeholder="Họ và tên *">
                                <input type="text" name="address" placeholder="Địa chỉ *">
                                <input type="number" name="phone" placeholder="Số điện thoại *">
                                <textarea name="note"  placeholder="Ghi chú đơn hàng của bạn" rows="5" ></textarea>		
                                <input name="send_order" type="submit" class="btn btn-primary btn-sm" value="Gửi" />
                            </form>
                        </div>
                        
                    </div>
                </div>
                			
            </div>
        </div>
        
    </div>
</section> <!--/#cart_items-->

@endsection