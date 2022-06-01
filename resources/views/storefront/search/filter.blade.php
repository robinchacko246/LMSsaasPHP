@if($total_row > 0)
    @foreach($data as $course)
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="card-section">
                <div class="card">
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
                    <div class="card-main">
                        <div class="card-img">
                            <div class="card-img-main">
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
                                <div class="like-tag">
                                    @if(Auth::guard('students')->check())
                                        @if(sizeof($course->student_wl)>0)
                                            @foreach($course->student_wl as $student_wl)
                                                <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Already in Wishlist')}}">
                                                    <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                </a>
                                                {{-- <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Wishlist')}}">
                                                    <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                </a> --}}
                                            @endforeach
                                        @else
                                            <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Wishlist')}}">
                                                <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                            </a>
                                        @endif
                                    @else
                                        <a class="like-a-tag add_to_wishlist" data-id="{{$course->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Wishlist')}}">
                                            <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-text">
                            <div class="card-heading">
                                <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                    <h4 class=" mb-0">{{$course->title}}</h4>
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
                                        <h4>{{$course->chapter_count->count()}}<span>{{__('Chapters')}}</span></h4>
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
@else
    <div class="col-xl-12 col-lg-12">
        <div class="result-section-bg">
            {{__('No Data Found')}}
        </div>
    </div>
@endif
