@extends('layouts.shopfront')
@section('page-title')
    {{__('Tutor')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@push('script-page')
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
@endpush
@section('content')
    <div class="over-menu"></div>
    <div id="wrap">
        <div class="course-page hero-section tutor-page">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-7 col-sm-12">
                        <div class="course-page-text mt-5">
                            <div class="course-category">
                                <div class="course-back">
                                    <a href="{{route('store.slug',$store->slug)}}">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        {{__('Back to home')}}
                                    </a>
                                </div>
                            </div>
                            <div class="category-heading tutor-heading py-5 d-flex align-items-start justify-content-between">
                                <div class="tutor-user-img">
                                    @if(!empty($tutor->avatar))
                                        <img src="{{asset(Storage::url('uploads/profile/'.$tutor->avatar))}}" alt="user" class="img-fluid">
                                    @else
                                        <img src="{{asset('assets/img/user.png')}}" alt="user" class="img-fluid">
                                    @endif
                                </div>
                                <div class="user-name-tutor">
                                    <div class="user-name-tutor-sec d-flex align-items-center">
                                        <h2 class="m-0">{{$tutor->name}}</h2>
                                    </div>
                                    <div class="featured-in my-4 d-flex align-items-start">
                                        <p>{{__('Featured in')}}
                                        </p>
                                        <div class="design-span">
                                            {{$tutor_course->category_id->name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-rate-section d-flex align-items-center justify-content-between mx-3 mb-0">
                                    <span>{{$avg_rating}} </span>
                                    <span class="star-img">
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                   </span>
                                    <p>({{$user_count}})</p>
                                </div>
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
                        <div class="total-section-bg p-3 px-5">
                            <ul class="total-section-main d-flex align-items-start justify-content-between">
                                <li class="total-section-sub">
                                    <h4>{{__('Rating')}}</h4>
                                    <div class="card-rate-section d-flex align-items-center">
                                        <span>{{$avg_rating}}</span>
                                        <span class="star-img">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                        <p>({{$user_count}})</p>
                                    </div>
                                </li>
                                <li class="total-section-sub">
                                    <h4>{{__('Total Students')}}</h4>
                                    <p>{{'0'}}</p>
                                </li>
                                <li class="total-section-sub">
                                    <h4>{{__('Total Courses')}}</h4>
                                    <p>{{$courses->count()}}</p>
                                </li>
                                <li class="total-section-sub">
                                    <h4>{{__('Master of')}}</h4>
                                    <div class="master-tag d-flex align-items-center justify-content-between">
                                        @if(!empty($tutor->degree))
                                            <div class="design-span programming-span">
                                                <span>{{$tutor->degree}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                                <li class="total-section-sub">
                                    <h4>{{__('Language')}}</h4>
                                    <p> {{$tutor_course->lang}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="course-second chapter-original-video">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-7 col-lg-7">
                        <div class="course-tab">
                            <div class="nav-tabs-wrapper">
                                <div class="tab-content">
                                    <div class="">
                                        <h2>
                                            {{$tutor_course['title']}}
                                        </h2>
                                        <p class="paragraph">
                                            {!! $tutor_course['course_description'] !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="featured-courses course-cart pt-20">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('Featured Courses')}}</h3>
                                <p class="m-0"></p>
                            </div>
                            <hr>
                            <div class="card-section">
                                <div class="card">
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <div class="card-main">
                                                <div class="card-img">
                                                    <div class="card-img-main d-flex align-items-center">
                                                        <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                                            @if(!empty($course->thumbnail))
                                                                <img src="{{asset(Storage::url('uploads/thumbnail/'.$course->thumbnail))}}" alt="card" class="img-fluid">
                                                            @else
                                                                <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="card-tag">
                                                        <div class="design-tag text-center">
                                                            <span>{{$course->category_id->name}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <div class="card-heading">
                                                        <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                                            <h4>
                                                                {{$course->title}}
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div class="card-rate-section d-flex align-items-center">
                                                        <span>{{$course->course_rating()}}</span>
                                                        <span class="star-img">
                                                           <i class="fa fa-star" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                    <div class="card-price-section">
                                                        <div class="card-price">
                                                            <h3>{{ Utility::priceFormat($course->price)}}</h3>
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
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="featured-section categories-section more-category-section">
            <div class="container-lg">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-12">
                        <div class="categories">
                            <span>{{__('Courses')}}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="categories-heading">
                            <h2>{{__('More from')}} <br><span> @ {{ $tutor->name }} </span></h2>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <div class="categories-text">
                            <div class="learn-more-btn learn-more-btn-second">
                                <a href="{{route('store.search',[$store->slug])}}" class="text-white"> {{__('Learn More')}} </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    @foreach($courses as $course)
                        <div class="col-lg-3 col-md-6 col-sm-12">
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
                                            <div class="card-tag">
                                                <div class="design-tag text-center">
                                                    <span>{{$course->category_id->name}}</span>
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
                                                <div class="like-tag">
                                                    @if(Auth::guard('students')->check())
                                                        @if(sizeof($course->student_wl)>0)
                                                            @foreach($course->student_wl as $student_wl)
                                                                <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}">
                                                                    <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                                </a>
                                                            @endforeach
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
                                                <p>(104,716)</p>
                                            </div>
                                            <div class="card-detail-main">
                                                <div class="card-detail">
                                                    <div class="card-detail-sub">
                                                        <div class="card-icon">
                                                            <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                                        </div>
                                                        <h4>{{$course->student_count->count()}}<span>{{__('Students')}}</span></h4>
                                                    </div>
                                                    <div class="card-detail-sub">
                                                        <div class="card-icon">
                                                            <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                                        </div>
                                                        <h4>{{$course->chapter_count->count()}}<span> {{__('Chapters')}}</span></h4>
                                                    </div>
                                                    <div class="card-detail-sub card-detail-beginner">
                                                        <h4> {{$course->level}} </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-price-section">
                                                <div class="card-price">
                                                    <h3>{{ ($course->is_free == 'on')? __('Free') : Utility::priceFormat($course->price)}}</h3>
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
        </section>
    </div>
@endsection
