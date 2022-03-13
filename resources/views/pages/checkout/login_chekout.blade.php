@extends('layout')
@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="#">
                        <input type="text" name="email_account" placeholder="Email" />
                        <input type="password" name="password_account" placeholder="Mật khẩu" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ đăng nhập
                        </span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng kí</h2>
                    <form action="{{URL::to('add-customer')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="name" placeholder="Tên tài khoản"/>
                        <input type="email" name="email" placeholder="Địa chỉ email"/>
                        <input type="password" name="password" placeholder="Mật khẩu"/>
                        <input type="number" name="phone" placeholder="Số điện thoại"/>
                        <button type="submit" class="btn btn-default">Đăng kí</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection