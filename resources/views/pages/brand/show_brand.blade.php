@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
    @foreach ($brand_name as $item )
        <h2 class="title text-center">{{$item->brand_name}}</h2>
    @endforeach

    @foreach ($brand_by_id as $key => $pro)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <input type="hidden" class="cart_product_id_{{$pro->id}}" value="{{$pro->id}}"/>
                            <input type="hidden" class="cart_product_name_{{$pro->id}}" value="{{$pro->name}}"/>
                            <input type="hidden" class="cart_product_image_{{$pro->id}}" value="{{$pro->image}}"/>
                            <input type="hidden" class="cart_product_price_{{$pro->id}}" value="{{$pro->price}}"/>
                            <input type="hidden" class="cart_product_qty_{{$pro->id}}" value="1"/>
                            
                            <a href="{{URL::to('/detail-product/'.$pro->id)}}">
                                <img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" />
                            
                                <h2>{{number_format($pro->price,0,',','.').'$'}}</h2>
                                <p>{{$pro->name}}</p>
                            {{-- <a href="#" class="btn btn-default add-to-cart">
                                <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng --}}
                            </a>
                            <button type="button" name="add-to-cart" data-id="{{$pro->id}}" class="btn btn-default add-to-cart">Thêm giỏ hàng</button>
                        </form>
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