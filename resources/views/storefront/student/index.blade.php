@extends('storefront.user.user')
@section('page-title')
    {{__('My purchased Courses')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{__('Welcome').', '.\Illuminate\Support\Facades\Auth::guard('students')->user()->name}}
@endsection
@section('content')
    <div class="course-page hero-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="course-page-text">
                        <div class="course-category">
                            <div class="course-back">
                                <a href="{{route('store.slug',$store->slug)}}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    {{__('Back to home')}}
                                </a>
                            </div>
                            <div class="design-span">
                                <span>{{!empty($course->category_id->name)?$course->category_id->name:''}}</span>
                            </div>
                        </div>
                        <div class="category-heading">
                            <h2>{{__('Courses you purchased')}}</h2>
                            <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="slice slice-lg delimiter-bottom">
        <div class="container">
            <div class="row">
                @if(!empty($purchased_course) && count($purchased_course) > 0)
                    @foreach($purchased_course as $purchased_course)
                        @if(in_array($purchased_course->id,Auth::guard('students')->user()->purchasedCourse()))
                            <div class="col col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="card-section">
                                    <div class="card">
                                        <div class="card-main">
                                            <div class="card-img">
                                                <div class="card-img-main">
                                                    <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($purchased_course->id),''])}}">
                                                        @if(!empty($purchased_course->thumbnail))
                                                            <img src="{{asset(Storage::url('uploads/thumbnail/'.$purchased_course->thumbnail))}}" alt="card" class="img-fluid">
                                                        @else
                                                            <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="card-tag">
                                                    <div class="design-tag text-center">
                                                        <span>{{!empty($purchased_course->category_id)?$purchased_course->category_id->name:''}}</span>
                                                    </div>
                                                    <div class="like-tag">
                                                        @if(Auth::guard('students')->check())
                                                            @if(sizeof($purchased_course->student_wl)>0)
                                                                {{-- @foreach($purchased_course->student_wl as $student_wl) --}}
                                                                    <a class="like-a-tag add_to_wishlist" data-id="{{$purchased_course->id}}" data-toggle="tooltip" data-placement="bottom" title="{{__('Already in Wishlist')}}">
                                                                        <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                                    </a>
                                                                {{-- @endforeach --}}
                                                            @else
                                                                <a class="like-a-tag add_to_wishlist" data-id="{{$purchased_course->id}}" data-toggle="tooltip" data-placement="bottom" title="{{__('Add to Wishlist')}}">
                                                                    <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a class="like-a-tag add_to_wishlist" data-id="{{$purchased_course->id}}" data-toggle="tooltip" data-placement="bottom" title="{{__('Add to Wishlist')}}">
                                                                <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $cart = session()->get($slug);
                                                   $key = false;
                                            @endphp
                                            @if(!empty($cart['products']))
                                                @foreach($cart['products'] as $k => $value)
                                                    @if($purchased_course->id == $value['product_id'])
                                                        @php
                                                            $key = $k
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            <div class="card-text">
                                                <div class="card-heading">
                                                    <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($purchased_course->id),''])}}">
                                                        <h4>{{$purchased_course->title}}</h4>
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
                                                                    if($purchased_course->course_rating() < $i && $purchased_course->course_rating() >= $newVal1)
                                                                    {
                                                                        $icon = 'fa-star-half-alt';
                                                                    }
                                                                    if($purchased_course->course_rating() >= $newVal1)
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
                                                            <h4>{{$purchased_course->student_count->count()}} <span>{{__('Students')}}</span></h4>
                                                        </div>
                                                        <div class="card-detail-sub">
                                                            <div class="card-icon">
                                                                <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                                            </div>
                                                            <h4>{{$purchased_course->chapter_count->count()}}<span>{{__('Chapters')}}</span></h4>
                                                        </div>
                                                        <div class="card-detail-sub card-detail-beginner">
                                                            <h4> {{$purchased_course->level}} </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-price-section">
                                                    <div class="add-cart">
                                                        @if(Auth::guard('students')->check())
                                                            @if(in_array($purchased_course->id,Auth::guard('students')->user()->purchasedCourse()))
                                                                <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($purchased_course->id),''])}}">
                                                                    {{__('Start Watching')}}
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            <div class="text-center">
                                <i class="fas fa-folder-open text-gray" style="font-size: 48px;"></i>
                                <h2>{{ __('Opps...') }}</h2>
                                <h6> {!! __('No data Found.') !!} </h6>
                            </div>
                        </td>
                    </tr>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush
