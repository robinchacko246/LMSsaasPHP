@extends('layouts.shopfront')
@section('page-title')
    {{__('Home')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@push('script-page')
    {{--CART--}}
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
                        $('.sale-section #cart-btn-' + id).html('Already in Cart');
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
    {{-- HEADER SECTION --}}
    @if($demoStoreThemeSetting['enable_header_section_img'] == 'on')
        <div class="hero-section">
            <div class="container-lg">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="hero-section-text">
                            @if(!empty($special_offer_courses) && isset($special_offer_courses))
                                <div class="special-offer d-flex align-items-center">
                                    <p class="special_offer_width">
                                        <span>{{__('Special offer')}}</span>
                                    </p>
                                    <p>
                                        {{$special_offer_courses->title}} {{ Utility::priceFormat($special_offer_courses->price)}} <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($special_offer_courses->id)])}}">{{__('Get now')}}</a>
                                    </p>
                                </div>
                            @endif
                            <div class="heading-text">
                                <h1>
                                    {{__('Knowledge from')}} <span> +300 {{__('categories')}} </span> {{__('in one place')}}.
                                </h1>
                                <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
                            </div>
                            <div class="heading-form">
                                <form action="{{route('store.search',[$store->slug])}}" method="get">
                                    <input type="search" placeholder="{{__('Search programming, design, math')}}..." name="search" id="search_box">
                                    <button type="submit" aria-hidden="true">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="scroll-down">
                                <a href="#brand-section">
                                    <div class="mouse"></div>
                                    <span>{{__('Scroll Down')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="hero-section-image">
                            <div class="hero-section-label hero-section-label-1">
                                <div class="hero-section-label-main">
									<span>
										<img src="{{asset('assets/img/Line.svg')}}" alt="label-1" class="img-fluid label-line">
									</span>
                                    <div class="label-text">
                                        <h3>+74</h3>
                                        <p>{{__('Reports courses')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-section-label hero-section-label-2">
                                <div class="hero-section-label-main">
									<span>
										<img src="{{asset('assets/img/triangle.svg')}}" alt="label-1"
                                             class="img-fluid label-triangle">
									</span>
                                    <div class="label-text">
                                        <h3>+30</h3>
                                        <p>{{__('Math courses')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <section class="brand-section" id="brand-section">
        <div class="container-lg">
            <div class="row pt-5">
                <div class="col-lg-12 text-center">
                    <div class="brand-heading">
                        <h4>{{__('Top')}} <span> {{__('brands of the world')}} </span> {{__('used our solutions')}}</h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center text-center">
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <img src="{{asset('assets/'.$store->theme_dir.'/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <img src="{{asset('assets/'.$store->theme_dir.'/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <img src="{{asset('assets/'.$store->theme_dir.'/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <img src="{{asset('assets/'.$store->theme_dir.'/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <img src="{{asset('assets/'.$store->theme_dir.'/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED COURSE --}}
    @if($demoStoreThemeSetting['enable_featuerd_course'] == 'on')
        @if($featured_course->count()>0)
            <section class="featured-section">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="featured-heading">
                                <div class="featured-heading-main">
                                    <h2>{{$demoStoreThemeSetting['featured_title']}}</h2>
                                </div>
                                <div class="learn-more-btn">
                                    <a href="{{route('store.search',[$store->slug])}}"> {{__('Show more')}} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        @foreach($featured_course as $course)
                            <div class="col col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="card-section">
                                    <div class="card">
                                        <div class="card-main">
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
                                            <div class="card-img">
                                                <div class="card-img-main">
                                                    @if(!empty($course->thumbnail))
                                                        <img alt="card" src="{{asset(Storage::url('uploads/thumbnail/'.$course->thumbnail))}}" class="img-fluid">
                                                    @else
                                                        <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="card-tag">
                                                    <div class="design-tag text-center">
                                                        <span>{{!empty($course->category_id)?$course->category_id->name:'-'}}</span>
                                                    </div>
                                                    <div class="like-tag">
                                                        @if(Auth::guard('students')->check())
                                                            @if(sizeof($course->student_wl)>0)
                                                                {{-- @foreach($course->student_wl as $student_wl) --}}
                                                                    <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-placement="top">
                                                                        <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                                    </a>
                                                                {{-- @endforeach --}}
                                                            @else
                                                                <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-placement="top">
                                                                    <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-placement="top">
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
                                                @if($store->enable_rating == 'on')
                                                    <div class="card-rate-section d-flex align-items-center">
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
                                                                <i class="fas {{$icon .' '. $color}}"></i>
                                                            @endfor
                                                        </span>
                                                    </div>
                                                @endif
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
                                                            <h4>{{$course->chapter_count->count()}}<span>{{__('Chapters')}}</span></h4>
                                                        </div>
                                                        <div class="card-detail-sub card-detail-beginner">
                                                            <h4> {{$course->level}} </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-price-section">
                                                    @if(Auth::guard('students')->check())
                                                        @if(in_array($course->id,Auth::guard('students')->user()->purchasedCourse()))
                                                            <div class="card-price">
                                                            </div>
                                                            <div class="add-cart">
                                                                <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($course->id),''])}}">
                                                                    {{__('Start Watching')}}
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="card-price">
                                                                @if($course->has_discount == 'on')
                                                                    <h3> {{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                @else
                                                                    <h3> {{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                @endif
                                                            </div>
                                                            <div class="add-cart">
                                                                @if($key !== false)
                                                                    <a id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</a>
                                                                @else
                                                                    <a id="cart-btn-{{$course->id}}" class="add_to_cart" data-id="{{$course->id}}">{{__('Add in Cart')}}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="card-price">
                                                            @if($course->has_discount == 'on')
                                                                <h3>{{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                            @else
                                                                <h3>{{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                            @endif
                                                        </div>
                                                        <div class="add-cart">
                                                            @if($key !== false)
                                                                <a id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</a>
                                                            @else
                                                                <a id="cart-btn-{{$course->id}}" class="add_to_cart" data-id="{{$course->id}}">{{__('Add in Cart')}}</a>
                                                            @endif
                                                        </div>
                                                    @endif
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
        @endif
    @endif

    {{-- CATEGORIES --}}
    @if($demoStoreThemeSetting['enable_categories'] == 'on')
        @if($categories->count()>0)
            <section class="categories-section">
                <div class="container-lg">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-12">
                            <div class="categories">
                                <span>{{$demoStoreThemeSetting['categories']}}</span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="categories-heading">
                                <h2>{{__('Knowledge from')}} <span> +300 {{__('categories')}} </span> {{__('in one place')}}. </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="categories-text">
                                <p>{{$demoStoreThemeSetting['categories_title']}}. </p>
                                <div class="learn-more-btn learn-more-btn-second">
                                    <a href="{{route('store.search',[$store->slug])}}" class="text-white"> {{__('Learn More')}} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5">
                        @foreach($categories as $category)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="categories-block mb-5">
                                    <div class="categories-block-main">
                                        <div class="categories-block-img">
                                            @if(!empty($category->category_image))
                                                <img alt="Image placeholder" src="{{asset(Storage::url('uploads/category_image/'.$category->category_image))}}" class="myimage img-fluid">
                                            @else
                                                <img src="{{asset('assets/img/business.svg')}}" alt="business" class="img-fluid">
                                            @endif
                                        </div>
                                        <a href="{{route('store.search',[$store->slug,Crypt::encrypt($category->id)])}}">
                                            <h3>{{$category->name}}</h3>
                                        </a>
                                        <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
                                        <div class="categories-link">
                                            <a href="{{route('store.search',[$store->slug])}}">
                                                {{__('Find more courses')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- COURSE --}}
    @if($courses->count()>0)
        <section class="featured-section sale-section">
            <div class="container-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="featured-heading">
                            <div class="featured-heading-main">
                                <h2>{{__('On Sale')}}</h2>
                            </div>
                            <div class="learn-more-btn">
                                <a href="{{route('store.search',[$store->slug])}}"> {{__('Show More')}} </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    @foreach($courses as $course)
                        @if(!empty($course->discount))
                            <div class="col col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="card-section">
                                    <div class="card">
                                        <div class="card-main">
                                            <!-- Card -->
                                            <div class="card-img">
                                                <div class="card-img-main">
                                                    @if(!empty($course->thumbnail))
                                                        <img alt="Image placeholder" src="{{asset(Storage::url('uploads/thumbnail/'.$course->thumbnail))}}" class="img-fluid">
                                                    @else
                                                        <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="card-tag">
                                                    <div class="design-tag text-center">
                                                        <span>{{!empty($course->category_id)? $course->category_id->name:'-'}}</span>
                                                        <span class="sale">{{__('Sale')}}</span>
                                                    </div>
                                                    <div class="like-tag">
                                                        @if(Auth::guard('students')->check())
                                                            @if(sizeof($course->student_wl)>0)
                                                                @foreach($course->student_wl as $student_wl)
                                                                    <a href="#" class="like-a-tag">
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
                                                        <h4>
                                                            {{$course->title}}
                                                        </h4>
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
                                                                <i class="fas {{$icon .' '. $color}}"></i>
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
                                                            <h4>{{$course->chapter_count->count()}}<span>{{__('Chapters')}}</span></h4>
                                                        </div>
                                                        <div class="card-detail-sub card-detail-beginner">
                                                            <h4> {{$course->level}} </h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Avatars -->
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
                                                {{--CART--}}
                                                <div class="card-price-section">
                                                    @if(Auth::guard('students')->check())
                                                        @if(in_array($course->id,Auth::guard('students')->user()->purchasedCourse()))
                                                            <div class="card-price">
                                                            </div>
                                                            <div class="add-cart">
                                                                <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($course->id),''])}}">
                                                                    {{__('Start Watching')}}
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="card-price">
                                                                @if($course->has_discount == 'on')
                                                                    <h3> {{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                    <sub>
                                                                        <del> {{ Utility::priceFormat($course->discount)}} </del>
                                                                    </sub>
                                                                @else
                                                                    <h3> {{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                    <sub>
                                                                        <del> {{ Utility::priceFormat($course->discount)}} </del>
                                                                    </sub>
                                                                @endif
                                                            </div>
                                                            <div class="add-cart">
                                                                @if($key !== false)
                                                                    <a id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</a>
                                                                @else
                                                                    <a id="cart-btn-{{$course->id}}" class="add_to_cart" data-id="{{$course->id}}">{{__('Add in Cart')}}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="card-price">
                                                            @if($course->has_discount == 'on')
                                                                <h3>{{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                <sub>
                                                                    <del> {{ Utility::priceFormat($course->discount)}} </del>
                                                                </sub>
                                                            @else
                                                                <h3>{{ ($course->is_free == 'on')? __('Free') :  Utility::priceFormat($course->price)}}</h3>
                                                                <sub>
                                                                    <del> {{ Utility::priceFormat($course->discount)}} </del>
                                                                </sub>
                                                            @endif
                                                        </div>
                                                        <div class="add-cart">
                                                            @if($key !== false)
                                                                <a id="cart-btn-{{$course->id}}">{{__('Already in Cart')}}</a>
                                                            @else
                                                                <a id="cart-btn-{{$course->id}}" class="add_to_cart" data-id="{{$course->id}}">{{__('Add in Cart')}}</a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif
  
    {{-- EMAIL SUBSCRIBER --}}
    @if($store->enable_subscriber == 'on')
        <section class="newsletter-section">
            <div class="container-lg">
                <div class="row">
                    <div class="col col-lg-12 theme-bg-color newsletter-part">
                        <div class="col col-lg-7 col-md-6 col-sm-12">
                            <div class="newsletter-section">
                                <div class="newsletter-text">
                                    <h4>{{__('Subscribe on Newsletter')}}</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum is simply dummy text of the printing and typesetting industry. </p>
                                </div>
                                <div class="newsletter-text newsletter-form">
                                    {{Form::open(array('route' => array('subscriptions.store_email', $store->id),'method' => 'POST'))}}
                                    {{Form::email('email',null,array('aria-label'=>'Enter your email address','placeholder'=>__('Enter Your Email Address')))}}
                                    <button type="submit">{{__('SUBSCRIBE')}}</button>
                                    {{Form::close()}}
                                    <span class="note">
										<p>{{__('We will never spam to you. Only useful info')}}</p>
									</span>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-5 col-md-6 col-sm-12">
                            <div class="newsletter-img">
                                @if(!empty($store->sub_img))
                                    <img src="{{asset(Storage::url('uploads/store_logo/'.$store->sub_img))}}" alt="newsletter" class="img-fluid">
                                @else
                                    <img src="{{asset('assets/'.$store->theme_dir.'/img/newsletter.png')}}" alt="newsletter" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
