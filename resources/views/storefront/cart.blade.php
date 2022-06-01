@extends('layouts.shopfront')
@section('page-title')
    {{__('Cart')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('content')
    <div class="course-page hero-section tutor-page cart-page">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="course-page-text pt-100">
                        <div class="course-category">
                            <div class="course-back">
                                <a href="{{route('store.slug',$store->slug)}}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    {{__('Back to home')}}
                                </a>
                            </div>
                        </div>
                        <div class="category-heading">
                            <h2>{{__('My Cart')}}</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $cart = session()->get($store->slug);
    @endphp
    @if(!empty($cart['products']) || $cart['products'] = [])
        <div class="cart-second">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12">
                        <div class="cart-main">
                            <div class="card-section">
                                @php
                                    $total = 0;
                                    $arr_course_id = [];
                                @endphp
                                @if(!empty($products))
                                    @foreach($products['products'] as $key => $product)
                                        @php
                                            $store_currency             = $store->currency;
                                            $price = str_replace($store_currency, '', $product['price']);
                                            $total += $price;
                                            array_push($arr_course_id , $product['id']);
                                        @endphp
                                        <div class="card">
                                            <div class="card-main d-flex justify-content-between mt-0 mx-0 mb-30">
                                                <div class="card-img cart-card-img">
                                                    @if(!empty($product['image']))
                                                        <img alt="Image placeholder" src="{{asset($product['image'])}}" style="width: 80px;">
                                                    @else
                                                        <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="card-text cart-card-text d-flex align-items-center justify-content-between">
                                                    <div class="card-heading">
                                                        <h4 class="m-0">{{$product['product_name']}}</h4>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="card-price">
                                                            <h3>{{($price>1)? Utility::priceFormat($price): Utility::priceFormat($price).'(Free)'}}</h3>
                                                        </div>
                                                        <div class="delete-icon">
                                                            <a href="">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <a href="#!" class="action-item mr-2" data-toggle="tooltip" data-original-title="{{__('Move to trash')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-product-cart-{{$key}}').submit();">
                                                            <i class="fas fa-times text-dark"></i>
                                                        </a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['delete.cart_item',[$store->slug,$product['product_id']]],'id'=>'delete-product-cart-'.$key]) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <div class="featured-courses course-cart m-0">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('My Cart')}}</h3>
                            </div>
                            <hr>
                            <div class="cart-section px-5">
                                <div class="cart">
                                    <div class="cart-main">
                                        @php
                                            $total = 0;
                                            $sub_total = 0;
                                        @endphp
                                        @if(!empty($cart['products']))
                                            @foreach($cart['products'] as $k => $value)
                                                @php
                                                    $total += $value['price'];
                                                    $sub_total += $value['price'];
                                                @endphp
                                                <p class="d-flex align-items-center justify-content-between m-0">
                                                    @if(!empty($value['image']))
                                                        <img alt="Image placeholder" class="mr-2" src="{{asset($value['image'])}}" style="width: 42px;">
                                                    @else
                                                        <img alt="Image placeholder" class="mr-2" src="{{asset('assets/img/user.png')}}" style="width: 42px;">
                                                    @endif
                                                    {{$value['product_name']}}
                                                    <span class="fw-bold">{{ Utility::priceFormat($value['price'])}}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between mt-4">
                                                    {{__('Coupon')}}
                                                    <span class="fw-bold dicount_price">0.00</span>
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="proceed_to_checkout pb-5">
                                <div class="summary d-flex align-items-center justify-content-between p-5">
                                    <p class="m-0">
                                        {{__('Total')}}
                                    </p>
                                    <p class="m-0" id="total_value" data-value="{{$total}}">
                                        <span class="total_price" data-value="{{$total}}"> {{ Utility::priceFormat($total)}}</span>
                                    </p>
                                </div>
                                <div class="proceed_to_checkout_btn mx-5 ">
                                    <a href="{{route('store.checkout',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt(json_encode($arr_course_id)),(!empty($total))?$total:0])}}" type="button" class="proceed_to_checkout_btn">
                                        {{__('Proceed to checkout')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-content">
            <section class="mh-100vh d-flex align-items-center" data-offset-top="#header-main">
                <!-- SVG background -->
                <div class="container pt-6 position-relative">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="text-center">
                                <!-- SVG illustration -->
                                <div class="row justify-content-center mb-5">
                                    <div class="col-md-5">
                                        <img alt="Image placeholder" src="{{asset('assets/img/online-shopping.svg')}}" class="svg-inject img-fluid">
                                    </div>
                                </div>
                                <!-- Empty cart container -->
                                <h6 class="h4 my-4">{{__('Your cart is empty')}}.</h6>
                                <p class="px-md-5">
                                    {{__('Your cart is currently empty.
                                    We have some great courses that you might want to learn')}}.
                                </p>
                                <a href="{{route('store.slug',$store->slug)}}" class="btn btn-sm btn-primary btn-icon rounded-pill my-5">
                                    <span class="btn-inner--icon"><i class="fas fa-angle-left"></i></span>
                                    <span class="btn-inner--text">{{__('Return to shop')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endif
@endsection
@push('script-page')
@endpush
