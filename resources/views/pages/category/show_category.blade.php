@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
    @foreach ($cate_name as $item )
        <h2 class="title text-center">{{$item->category_name}}</h2>
    @endforeach
    
    @foreach ($category_by_id as $key => $pro)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" />
                            <h2>{{number_format($pro->price,0,',','.').'$'}}</h2>
                            <p>{{$pro->name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                        </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
    
</div><!--features_items-->

@endsection