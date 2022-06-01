@extends('layouts.shopfront')
@section('page-title')
    {{__('Search')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
    <style>
        .result-section-bg {
            background: var(--bg-white);
            box-shadow: 0px 18px 42px rgb(171 171 171 / 13%);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
@endpush
@push('script-page')
    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
    <script src="https://unpkg.com/range-slider-element@latest"></script>
    <script>
        $(document).on('click', '.add_to_cart', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: '{{route('user.addToCart', ['__product_id',$store->slug])}}'.replace('__product_id', id),
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status == "Success") {
                        show_toastr('Success', response.success, 'success');
                        $('#cart-btn-' + id).html('Already in Cart');
                        $('.cart_item_count').html(response.item_count);
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }

                },
                error: function (result) {
                }
            });
        });
    </script>
    <script>
        var selected = [];
        var price = [];
        var level_arr = [];
        $(document).on('change', '.checkbox_filter', function () {
            var c_data = $(this).attr('cat');
            var is_free = $(this).attr('price');
            var level = $(this).attr('level');
            if ($(this).is(":checked")) {
                if (!selected.includes(c_data)) {
                    selected.push(c_data);
                }
                if (!price.includes(is_free)) {
                    price.push(is_free);
                }
                if (!level_arr.includes(level)) {
                    level_arr.push(level);
                }
                var data = {
                    checked: selected,
                    is_free: price,
                    level: level_arr,
                };

                filter(data);
            } else {
                selected = jQuery.grep(selected, function (value) {
                    return value != c_data;
                });
                price = jQuery.grep(price, function (value) {
                    return value != is_free;
                });
                level_arr = jQuery.grep(level_arr, function (value) {
                    return value != level;
                });
                var data = {
                    checked: selected,
                    is_free: price,
                    level: level_arr,
                };
                filter(data);
            }
        });

        function filter(data) {
            $.ajax({
                url: "{{ route('store.filter',$store->slug) }}",
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function (data) {
                    $('#course_div').html('');
                    $('#course_div').html(data.table_data);
                    $('#result_found').html('');
                    $('#result_found').html(data.total_row + ' result found');
                }
            });
        }
    </script>
@endpush
@section('content')
    <div id="wrap">
        <div class="course-page hero-section tutor-page">
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
                                <h2>{{__('Search Data')}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="total-section">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="total-section-bg p-4 px-5">
                            <form action="{{route('store.search',[$store->slug])}}" method="get" class="categories-search d-flex align-items-center m-0">
                                <div class="categories-search-dropdown d-flex">
                                    <div class="form-group categories-search-main m-0">
                                        <label for="text">{{__('Search')}}</label>
                                        <input type="text" class="form-control" placeholder="{{__('Search programming, design, math')}}..." name="search" id="search_box">
                                    </div>
                                    <div class="form-group categories-dropdown m-0">
                                        <label for="Category">{{__('Category')}}</label>
                                        <div class="dropdown category-dropdown-main">
                                            <div class="select d-flex justify-content-between w-100">
                                                <span>{{__('Business')}}</span>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <input type="hidden" name="Category">
                                            <ul class="dropdown-menu">
                                                @foreach($category as $cat)
                                                    <li id="Business">
                                                        <input type="checkbox" id="checkbox-{{$cat->id}}" class="checkbox_filter" name="checkbox_filter{{$cat->id}}" data-type="category" cat="{{$cat->id}}">
                                                        <label for="checkbox-{{$cat->id}}" id="checkbox-{{$cat->id}}">{{$cat->name}}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="categories-search-btn">
                                    <div class="form-group m-0">
                                        <button type="submit" class="btn p-0">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="course-second chapter-original-video">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="featured-courses cart-border pt-20 mb-4">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('Category')}}</h3>
                                <p class="m-0" {{$category->count()}}</p>
                            </div>
                            <hr>
                            <div class="category-checkbox px-5">
                                @foreach($category as $cat)
                                    <div class="form-group">
                                        <input type="checkbox" id="checkbox{{$cat->id}}" class="checkbox_filter" name="checkbox_filter{{$cat->id}}" data-type="category" cat="{{$cat->id}}">
                                        <label for="checkbox{{$cat->id}}" id="checkbox{{$cat->id}}">{{$cat->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="featured-courses cart-border pt-20 mb-4">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('Level')}}</h3>
                            </div>
                            <hr>
                            <div class="category-checkbox px-5">
                                @php
                                    $i = 0
                                @endphp
                                @foreach( Utility::course_level() as $level)
                                    <div class="form-group">
                                        <input type="checkbox" id="level{{$i}}" name="checkbox_filter" class="form-control checkbox_filter" data-type="level" level="{{$level}}">
                                        <label for="level{{$i}}" id="checkbox{{$i}}">{{$level}}</label>
                                    </div>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="featured-courses cart-border pt-20 mb-5">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('Price')}}</h3>
                            </div>
                            <hr>
                            <div class="category-checkbox px-5">
                                <div class="form-group">
                                    <input type="checkbox" id="price1" name="checkbox_filter" class="form-control checkbox_filter" data-type="price" price="on">
                                    <label for="price1">{{__('Free')}}</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="price2" name="checkbox_filter" class="form-control checkbox_filter" data-type="price" price="off">
                                    <label for="price2">{{__('Paid')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 p-0">
                        <div class="col-xl-12 col-lg-12">
                            <div class="result-section-bg">
                                @if($search_d == null)
                                    <span id="result_found"></span>
                                @else
                                    <span>{{$courses->count()}} {{__('result found for')}}</span> "<b> {{$search_d}} </b>"
                                @endif
                            </div>
                        </div>
                        <div class="categories-card" id="course_div">
                            @foreach($courses as $course)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="card-section">
                                        <div class="card">
                                            <div class="card-main">
                                                <div class="card-img">
                                                    <div class="card-img-main">
                                                        @if(!empty($course->thumbnail))
                                                            <img src="{{asset(Storage::url('uploads/thumbnail/'.$course->thumbnail))}}" alt="card" class="img-fluid">
                                                        @else
                                                            <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                        @endif
                                                    </div>
                                                    @php
                                                        $cart = session()->get($slug);
                                                        $key = false;
                                                    @endphp
                                                    @if(!empty($cart['products']))
                                                        @foreach($cart['products'] as $k => $value)
                                                            @if($course->id == $value['product_id'])
                                                                @php
                                                                    $key = $k
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <div class="card-tag">
                                                        <div class="design-tag text-center">
                                                            <span>{{!empty($course->category_id->name)?$course->category_id->name:''}}</span>
                                                        </div>
                                                        <div class="like-tag">
                                                            @if(Auth::guard('students')->check())
                                                                @if(sizeof($course->student_wl)>0)
                                                                    {{-- @foreach($course->student_wl as $student_wl) --}}
                                                                        <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}">
                                                                            <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                                        </a>
                                                                    {{-- @endforeach --}}
                                                                @else
                                                                    <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}">
                                                                        <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}">
                                                                    <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <div class="card-heading">
                                                        <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                                            <h4>{{$course->title}}</h4>
                                                        </a>
                                                    </div>
                                                    <div class="card-rate-section d-flex align-items-center">
                                                        @if($store->enable_rating == 'on')
                                                            <span class="static-rating static-rating-sm d-block">
                                                                @for($i =1;$i<=5;$i++)
                                                                    @php
                                                                        $icon = 'fa-star';
                                                                        $color = '';
                                                                        $newVal1 = ($i-0.5);
                                                                            if($course->course_rating() < $i && $course->course_rating() >= $newVal1)
                                                                            {
                                                                                $icon = 'fa-star-half-alt';
                                                                            }
                                                                            if($course->course_rating() >= $newVal1)
                                                                            {
                                                                                $color = 'text-warning';
                                                                            }
                                                                    @endphp
                                                                    <i class="fa {{$icon .' '. $color}}"></i>
                                                                @endfor
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="card-detail-main">
                                                        <div class="card-detail">
                                                            <div class="card-detail-sub">
                                                                <div class="card-icon">
                                                                    <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                                                </div>
                                                                <h4>{{$course->student_count->count()}} <span>{{__('Students')}}</span></h4>
                                                            </div>
                                                            <div class="card-detail-sub">
                                                                <div class="card-icon">
                                                                    <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                                                </div>
                                                                <h4>{{$course->chapter_count->count()}}<span>{{__('Chapter')}}</span></h4>
                                                            </div>
                                                            <div class="card-detail-sub card-detail-beginner">
                                                                <h4> {{$course->level}} </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-price-section">
                                                        <div class="card-price">
                                                            <h3>{{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                        </div>
                                                        <div class="add-cart">
                                                            @if(Auth::guard('students')->check())
                                                                @if(in_array($course->id,Auth::guard('students')->user()->purchasedCourse()))
                                                                    <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($course->id),''])}}">
                                                                        {{__('Start Watching')}}
                                                                    </a>
                                                                @else
                                                                    <a class="add_to_cart" data-id="{{$course->id}}">
                                                                        @if($key !== false)
                                                                            <b id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</b>
                                                                        @else
                                                                            <b id="cart-btn-{{$course->id}}">{{__('Add in Cart')}}</b>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a class="add_to_cart" data-id="{{$course->id}}">
                                                                    @if($key !== false)
                                                                        <b id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</b>
                                                                    @else
                                                                        <b id="cart-btn-{{$course->id}}">{{__('Add in Cart')}}</b>
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
