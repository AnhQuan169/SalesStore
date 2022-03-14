@extends('layout')
@section('content')
@foreach ($details_product as $key => $pro )
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" />
                <h3>ZOOM</h3>
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">
                
                <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                        <a href=""><img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" width="90px"></a>
                        <a href=""><img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" width="90px"></a>
                        <a href=""><img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" width="90px"></a>
                        </div>
                    </div>

                <!-- Controls -->
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>

        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="{{URL::to('public/client/images/product-details/new.jpg')}}" class="newarrival" alt="" />
                <h2>{{$pro->name}}</h2>
                <p>Mã ID: {{$pro->id}}</p>
                <img src="{{URL::to('public/client/images/product-details/rating.png')}}" alt="" />
                <form>
                    @csrf
                    <input type="hidden" class="cart_product_id_{{$pro->id}}" value="{{$pro->id}}"/>
                    <input type="hidden" class="cart_product_name_{{$pro->id}}" value="{{$pro->name}}"/>
                    <input type="hidden" class="cart_product_image_{{$pro->id}}" value="{{$pro->image}}"/>
                    <input type="hidden" class="cart_product_price_{{$pro->id}}" value="{{$pro->price}}"/>

                    <span>
                        <span>{{number_format($pro->price,0,',','.')}} VND</span>
                        <label>Quantity:</label>
                        {{-- Số lượng sản phẩm đã chọn --}}
                        <input type="number" class="cart_product_qty_{{$pro->id}}" min="1" value="1"/>
                        <input name="product_id_hidden" type="hidden" value="{{$pro->id}}" />
                        {{-- <button type="button" class="btn btn-default cart" name="add-to-cart" data-id="{{$pro->id}}" >
                            <i class="fa fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button> --}}
                        <button type="button" name="add-to-cart" data-id="{{$pro->id}}" class="btn btn-default add-to-cart">
                            <i class="fa fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button>

                    </span>

                </form>
                <p><b>Tình trạng:</b> Còn hàng</p>
                <p><b>Điều kiện:</b> Mới 100%</p>
                <p><b>Danh mục:</b> {{$pro->category_name}}</p>
                <p><b>Thương hiệu:</b> {{$pro->brand_name}}</p>
                <a href=""><img src="{{URL::to('public/client/images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->
    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Nội dung sản phẩm</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Mô tả sản phẩm</a></li>
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details" >
                <p>{!!$pro->content!!}</p>
            </div>
            
            <div class="tab-pane fade" id="companyprofile" >
                <p>{!!$pro->desc!!}</p>
            </div>
            
            
            <div class="tab-pane fade " id="reviews" >
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>
                    
                    <form action="#">
                        <span>
                            <input type="text" placeholder="Your Name"/>
                            <input type="email" placeholder="Email Address"/>
                        </span>
                        <textarea name="" ></textarea>
                        <b>Rating: </b> <img src="{{URL::to('public/client/images/product-details/rating.png')}}" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div><!--/category-tab-->
@endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>
        
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">	
                    @foreach ($related_product as $key =>$pro )
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
                                                <img src="{{URL::to('public/uploads/products/'.$pro->image)}}" alt="" height="150px"/>

                                                <h2>{{number_format($pro->price,0,',','.').'$'}}</h2>
                                                <p>{{$pro->name}}</p>
                                            {{-- <a href="#" class="btn btn-default add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng --}}
                                            </a>
                                            <button type="button" name="add-to-cart" data-id="{{$pro->id}}" class="btn btn-default add-to-cart">Thêm giỏ hàng</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                <div class="item">	
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{URL::to('public/client/images/home/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>			
        </div>
    </div><!--/recommended_items-->  

@endsection