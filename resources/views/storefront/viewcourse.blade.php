@extends('layouts.shopfront')
@php
    $profile = asset(Storage::url('uploads/default_avatar/avatar.png'));
@endphp
@section('meta-data')
    <meta name="keywords" content="{{$course->meta_keywords}}">
    <meta name="description" content="{{$course->meta_description}}">
@endsection
@section('page-title')
    {{__('Course Details')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
    <script src="{{asset('assets/js/bootstrap-bundle-min.5.0.1.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/css/moovie.css')}}">
    <style>
        .divider-vertical {
            left: 50%;
            top: 10%;
            bottom: 10%;
            border-left: 1px solid white;
        }
    </style>
@endpush
@push('script-page')
    <script src="{{asset('assets/js/moovie.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var demo1 = new Moovie({
                selector: "#example",
                dimensions: {
                    width: "100%"
                },
                config: {
                    storage: {
                        captionOffset: false,
                        playrateSpeed: false,
                        captionSize: false
                    }
                }
            });
        });

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
                                <span>{{!empty($course->category_id)?$course->category_id->name:''}}</span>
                            </div>
                        </div>
                        <div class="category-heading">
                            <h2>{{$course->title}}</h2>
                            <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="course-second">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="course-video">
                        <div class="course-video-main">
                            @if($course->is_preview == 'on')
                                @if($course->preview_type == 'Video File')
                                    <video id="example" class="preview_video" poster="{{asset('assets/img/video-img.png')}}">
                                        <source src="{{asset(Storage::url('uploads/preview_video/'.$course->preview_content))}}" type="video/mp4">
                                        <track kind="captions" label="Portuguese" srclang="pt"
                                               src="https://raw.githubusercontent.com/BMSVieira/moovie.js/main/demo-template/subtitles/pt.vtt">
                                        <track kind="captions" label="English" srclang="en"
                                               src="https://raw.githubusercontent.com/BMSVieira/moovie.js/main/demo-template/subtitles/en.vtt">
                                        <track kind="captions" label="French" srclang="en"
                                               src="https://raw.githubusercontent.com/BMSVieira/moovie.js/main/demo-template/subtitles/french.srt">
                                        {{__('Your browser does not support the video tag')}}.
                                    </video>
                                @elseif($course->preview_type == 'Image')
                                    <div class="container">
                                        <img src="{{asset(Storage::url('uploads/preview_image/'.$course->preview_content))}}" class="img-fluid">
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="course-tab">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs d-flex align-items-center justify-content-between" id="myTabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#overview" role="tab" data-toggle="tab" aria-controls="home"
                                       aria-expanded="true">
                                        <img src="{{asset('assets/img/overview.svg')}}" alt="overview" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/unselect-overview.svg')}}" alt="overview"
                                             class="img-fluid unselect-tab-img">
                                        {{__('Overview')}}</a>
                                </li>
                                <li role="presentation">
                                    <a href="#profile" role="tab" data-toggle="tab" aria-controls="profile">
                                        <img src="{{asset('assets/img/syllabus.svg')}}" alt="syllabus" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/syllabus-unselect.svg')}}" alt="syllabus"
                                             class="img-fluid unselect-tab-img">{{__('Syllabus')}}</a>
                                </li>
                                <li role="presentation">
                                    <a href="#tutor" role="tab" data-toggle="tab" aria-controls="profile">
                                        <img src="{{asset('assets/img/tutor.svg')}}" alt="tutor" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/tutor-unselect.svg')}}" alt="tutor"
                                             class="img-fluid unselect-tab-img">
                                        {{__('Tutor')}}</a>
                                </li>
                                <li role="presentation">
                                    <a href="#course-review" role="tab" data-toggle="tab" aria-controls="profile">
                                        <img src="{{asset('assets/img/star-select.svg')}}" alt="star" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/star-unselect.svg')}}" alt="star" class="img-fluid unselect-tab-img">
                                        {{__('Course Review')}}</a>
                                </li>
                                <li role="presentation">
                                    <a href="#faq-tab" role="tab" data-toggle="tab" aria-controls="profile">
                                        <img src="{{asset('assets/img/faq.svg')}}" alt="faq" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/faq-unselect.svg')}}" alt="faq" class="img-fluid unselect-tab-img">
                                        {{__('FAQs')}}</a>
                                </li>
                                <li class="nav-underline" role="presentation"></li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in active" role="tabpanel" id="overview" aria-labelledby="overview">
                                    <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                        <h2>
                                            {{$course->title}}
                                        </h2>
                                    </a>
                                    <p class="paragraph">
                                        {!! $course->course_description !!}
                                    </p>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab">
                                    <div class="accordian-tab">
                                        <div class="accordion" id="accordionExample">
                                            @if(count($header) > 0  && !empty($header))
                                                @foreach($header as $i => $header)
                                                    <div class="accordion-item mb-4">
                                                        <div class="accordion-header" id="headingOne">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ChapterOne-{{$i}}" aria-expanded="true" aria-controls="ChapterOne">
                                                                <p>
                                                                    {{$header->title}}
                                                                </p>
                                                            </button>
                                                        </div>
                                                        <div id="ChapterOne-{{$i}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body my-4">
                                                                @if($header->chapters_data->count() > 0  && !empty($header->chapters_data))
                                                                    @foreach($header->chapters_data as $chapters)
                                                                        @if($chapters->type == 'Video File')
                                                                            <div class="col-12">
                                                                                <a href="{{route('store.fullscreen',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id),\Illuminate\Support\Facades\Crypt::encrypt($chapters->id)])}}" class="text-dark">
                                                                                    <img src="{{asset('assets/img/media.svg')}}" alt="media" class="img-fluid">
                                                                                    <span class="ml-3">{{$chapters->name}}</span> [{{!empty($chapters->duration)?$chapters->duration:''}}]
                                                                                </a>
                                                                            </div>
                                                                        @elseif($chapters->type == 'iFrame')
                                                                            <div class="col-12 mt-4">
                                                                                <a href="{{route('store.fullscreen',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id),\Illuminate\Support\Facades\Crypt::encrypt($chapters->id)])}}" class="text-dark">
                                                                                    <img src="{{asset('assets/img/media.svg')}}" alt="media" class="img-fluid">
                                                                                    <span>{{$chapters->name}}</span> [{{!empty($chapters->duration)?$chapters->duration:''}}]
                                                                                </a>
                                                                            </div>
                                                                        @elseif($chapters->type == 'Text Content')
                                                                            <div class="col-12 mt-4">
                                                                                <a href="{{route('store.fullscreen',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id),\Illuminate\Support\Facades\Crypt::encrypt($chapters->id)])}}" class="text-dark">
                                                                                    <img src="{{asset('assets/img/media.svg')}}" alt="media" class="img-fluid">
                                                                                    <span>{{$chapters->name}}</span>[{{!empty($chapters->duration)?$chapters->duration:''}}]
                                                                                </a>
                                                                            </div>
                                                                        @elseif($chapters->type == 'Video Url')
                                                                            <div class="col-12 mt-4">
                                                                                <a href="{{route('store.fullscreen',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id),\Illuminate\Support\Facades\Crypt::encrypt($chapters->id)])}}" class="text-dark">
                                                                                    <img src="{{asset('assets/img/media.svg')}}" alt="media" class="img-fluid">
                                                                                    <span>{{$chapters->name}}</span> [{{!empty($chapters->duration)?$chapters->duration:''}}]
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <p class="p-3 mt-4">
                                                                        {{__('No Chapters Available!')}}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <b>
                                                    {{__('No Chapters Available!')}}
                                                </b>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="tutor" aria-labelledby="dropdown1-tab">
                                    <div class="tutor-reviews">
                                        <div class="tutor-reviews-head">
                                            <div class="tutor-user-detail">
                                                <div class="tutor-user-img">
                                                    <img src="{{asset('assets/img/user.png')}}" alt="user" class="img-fluid">
                                                </div>
                                                <div class="tutor-user-detail-main">
                                                    <a href="{{route('store.tutor',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($tutor_id)])}}">
                                                        <a href="{{route('store.tutor',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($tutor_id)])}}">
                                                            <h3>{{$course->tutor_id->name}}</h3>
                                                        </a>
                                                    </a>
                                                    <span>{{$course->tutor_id->about}}</span>
                                                    @if($store->enable_rating == 'on')
                                                        <div class="card-rate-section d-flex align-items-center">
                                                            <span>{{$avg_tutor_rating}}/5</span>
                                                            <span class="star-img">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                             </span>
                                                            <p>({{$tutor_count_rating}})</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-review">
                                                <ul>
                                                    <li>
                                                        <p>{{__('Reviews')}} {{'0'}}</p>
                                                        <img src="{{asset('assets/img/star-unselect.svg')}}" alt="star" class="img-fluid">
                                                    </li>
                                                    <li>
                                                        <p>{{__('Course')}} {{$tutor_course_count->count()}}</p>
                                                        <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                                    </li>
                                                    <li>
                                                        <p>{{__('Students')}} {{$course->student_count->count()}}</p>
                                                        <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="paragraph">
                                            {{$course->tutor_id->description}}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="course-review" aria-labelledby="dropdown1-tab">
                                    <div class="course-review-tab">
                                        <div class="course-review-rating">
                                            <div class="card-rate-section d-flex align-items-center justify-content-between">
                                                <h4>{{$avg_rating}}/5</h4>
                                                <p>({{$user_count}} {{__('Rating')}})</p>
                                                <span class="star-img">
                                                    @for($i =1;$i<=5;$i++)
                                                        @php
                                                            $icon = 'fa-star';
                                                            $color = '';
                                                            $newVal1 = ($i-0.5);
                                                            if($avg_rating < $i && $avg_rating >= $newVal1)
                                                            {
                                                                $icon = 'fa-star-half-alt';
                                                            }
                                                            if($avg_rating >= $newVal1)
                                                            {
                                                                $color = 'text-warning';
                                                            }
                                                        @endphp
                                                        <i class="fa {{$icon .' '. $color}}"></i>
                                                    @endfor
                                                </span>
                                                @if(Auth::guard('students')->check())
                                                    <div class="add-cart">
                                                        <a href="#" data-size="lg" data-toggle="modal" data-url="{{route('rating',[$store->slug,$course->id])}}" data-ajax-popup-blur="true" data-title="{{__('Create New Rating')}}">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-review">
                                                <ul>
                                                    <li>
                                                        <p>{{__('Reviews')}} 30</p>
                                                        <img src="{{asset('assets/img/star-unselect.svg')}}" alt="star" class="img-fluid">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @if(!empty($course_ratings))
                                            @foreach($course_ratings as $c_rating_key => $course_rating)
                                                <div class="course-review-main">
                                                    <div class="course-review-main-sub">
                                                        <div class="course-review-name">
                                                            <h3> {{$course_rating->title}} </h3>
                                                        </div>
                                                        <div class="course-review-star">
                                                            <div class="course-review-star-img">
                                                                 <span class="star-img">
                                                                   @for($i =0;$i<5;$i++)
                                                                         <i class="fas fa-star {{($course_rating->ratting > $i  ? 'text-warning' : '')}}"></i>
                                                                     @endfor
                                                                 </span>
                                                                @if(Auth::check())
                                                                    <a href="#" class="action-item mr-2" data-size="lg" data-toggle="modal" data-url="{{route('rating.edit',$course_rating->id)}}" data-ajax-popup="true" data-title="{{__('Edit Rating')}}">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a href="#" class="action-item mr-2 " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$course_rating->id}}').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['rating.destroy', $course_rating->id],'id'=>'delete-form-'.$course_rating->id]) !!}
                                                                    {!! Form::close() !!}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="paragraph">
                                                        {{$course_rating->description}}
                                                    </p>
                                                    <div class="course-review-profile">
                                                        <div class="course-review-profile-img">
                                                            <img src="{{asset('assets/img/user.png')}}" alt="user" class="img-fluid">
                                                        </div>
                                                        <div class="course-review-user-name">
                                                            <h4>{{$course_rating->name}}</h4>
                                                            <p>{{$course_rating->created_at->diffForHumans()}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="faq-tab" aria-labelledby="dropdown2-tab">
                                    <div class="accordian-tab">
                                        <div class="accordion" id="accordionExamples">
                                            @if(count($faqs) > 0  && !empty($faqs))
                                                @foreach($faqs as $q_i => $faq)
                                                    <div class="accordion-item mb-4">
                                                        <div class="accordion-header" id="headingFour">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ChapterFour-{{$q_i}}" aria-expanded="true" aria-controls="ChapterFour">
                                                                <p><span>{{__('Question')}}:</span>{{$faq->question}}?</p>
                                                            </button>
                                                        </div>
                                                        <div id="ChapterFour-{{$q_i}}" class="accordion-collapse collapse"
                                                             aria-labelledby="headingFour" data-bs-parent="#accordionExamples">
                                                            <div class="accordion-body">
                                                                <p class="paragraph">{{$faq->answer}}.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="accordion-item mb-4">
                                                    <div class="accordion-header" id="headingFour">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#Chapte" aria-expanded="true" aria-controls="ChapterFour">
                                                            <p>{{__('There are no FAQs!')}}</p>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $cart = session()->get($store->slug);
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
                <div class="col-xl-4 col-lg-4">
                    <div class="course-cart pt-3 pb-4">
                        <div class="course-cart-head px-5">
                            <div class="design-span d-flex align-items-center">
                                <span>{{!empty($course->category_id)?$course->category_id->name:''}}</span>
                                <div class="card-tag" style="position: relative !important;">
                                    <div class="like-tag">
                                        @if(Auth::guard('students')->check())
                                            @if(sizeof($course->student_wl)>0)
                                                @foreach($course->student_wl as $student_wl)
                                                    <a class="like-a-tag add_to_wishlist fygyfg_{{$course->id}}" data-id-2="{{$course->id}}" style="box-shadow: 0px 0px 4px #dadada;">
                                                        <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                    </a>
                                                @endforeach
                                            @else
                                                <a class="like-a-tag add_to_wishlist fygyfg_{{$course->id}}" data-id-2="{{$course->id}}" style="box-shadow: 0px 0px 4px #dadada;">
                                                    <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                </a>
                                            @endif
                                        @else
                                            <a class="like-a-tag add_to_wishlist fygyfg_{{$course->id}}" data-id-2="{{$course->id}}" style="box-shadow: 0px 0px 4px #dadada;">
                                                <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-rate-section d-flex align-items-center justify-content-between">
                                <span>{{$avg_tutor_rating}}/5</span>
                                <span class="star-img">
                                  <i class="fa fa-star" aria-hidden="true"></i>
                               </span>
                                <p>({{$tutor_count_rating}})</p>
                            </div>

                        </div>
                        <div class="course-cart-title px-5">
                            <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course->id)])}}">
                                <h4>{{$course->title}}</h4>
                            </a>
                        </div>
                        <div class="course-cart-user px-5">
                            <div class="course-cart-user-img">
                                <img src="{{asset('assets/img/user.png')}}" alt="user" class="img-fluid">
                            </div>
                            <div class="course-cart-user-name">
                                <p>{{$course->tutor_id->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="course-all-details px-5">
                            <ul>
                                <li>
                                    <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                    <p>{{__('Duration')}} <span> {{$course->duration}} </span></p>
                                </li>
                                <li>
                                    <img src="{{asset('assets/img/star-unselect.svg')}}" alt="star" class="img-fluid">
                                    <p>{{__('Skill Level')}} <span> {{$course->level}} </span></p>
                                </li>
                                <li>
                                    <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                    <p>{{__('Total Enrolled')}} <span> {{$course->student_count->count()}} </span></p>
                                </li>
                                <li>
                                    <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                    <p>{{__('Chapters')}} <span> {{$course->chapter_count->count()}} </span></p>
                                </li>
                                <li>
                                    <img src="{{asset('assets/img/cube.svg')}}" alt="cube" class="img-fluid">
                                    <p>{{__('Language')}} <span> {{$course->lang}} </span></p>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="card-price-section px-5">
                            <div class="card-price">
                                <h3>{{ ($course->is_free == 'on')? 'Free' :  Utility::priceFormat($course->price)}}</h3>
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
    @if($more_by_category->count()>0)
        <section class="featured-section categories-section more-category-section">
            <div class="container-lg">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-12">
                        <div class="categories">
                            <span>{{__('Categories')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured-heading">
                            <div class="categories-heading">
                                <h2>{{__('More from')}} <span>  {{!empty($category_name)?$category_name->name:''}} </span> {{__('category')}} </h2>
                            </div>
                            <div class="categories-text">
                                <div class="learn-more-btn learn-more-btn-second">
                                    <a href="{{route('store.search',[$store->slug])}}"> {{__('Learn More')}} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-start">
                    @foreach($more_by_category as $course_by_cat)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="card-section">
                                <div class="card">
                                    <div class="card-main">
                                        <div class="card-img">
                                            <div class="card-img-main">
                                                <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course_by_cat->id)])}}">
                                                    @if(!empty($course_by_cat->thumbnail))
                                                        <img src="{{asset(Storage::url('uploads/thumbnail/'.$course_by_cat->thumbnail))}}" alt="card" class="img-fluid">=
                                                    @else
                                                        <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">=
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-tag">
                                                <div class="design-tag text-center">
                                                    <span>{{!empty($course->category_id)?$course->category_id->name:''}}</span>
                                                </div>
                                                <div class="like-tag">
                                                    @if(Auth::guard('students')->check())
                                                        @if(sizeof($course_by_cat->student_wl)>0)
                                                            @foreach($course_by_cat->student_wl as $student_wl)
                                                                <a class="like-a-tag add_to_wishlist" data-id="{{$course_by_cat->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Already in Wishlist')}}">
                                                                    <img src="{{asset('assets/img/wishlist.svg')}}" alt="like" class="img-fluid">
                                                                </a>
                                                            @endforeach
                                                        @else
                                                            <a class="like-a-tag add_to_wishlist" data-id="{{$course_by_cat->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Wishlist')}}">
                                                                <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a class="like-a-tag add_to_wishlist" data-id="{{$course_by_cat->id}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Wishlist')}}">
                                                            <img src="{{asset('assets/img/like.svg')}}" alt="like" class="img-fluid">
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-text">
                                            <div class="card-heading">
                                                <a href="{{route('store.viewcourse',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($course_by_cat->id)])}}">
                                                    <h4>{{$course_by_cat->title}}</h4>
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
                                                                if($course_by_cat->course_rating() < $i && $course_by_cat->course_rating() >= $newVal1)
                                                                {
                                                                    $icon = 'fa-star-half-alt';
                                                                }
                                                                if($course_by_cat->course_rating() >= $newVal1)
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
                                                        <h4>{{$course_by_cat->student_count->count()}} <span>{{__('Students')}}</span></h4>
                                                    </div>
                                                    <div class="card-detail-sub">
                                                        <div class="card-icon">
                                                            <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                                        </div>
                                                        <h4>{{$course_by_cat->chapter_count->count()}}<span>{{__('Chapters')}}</span></h4>
                                                    </div>
                                                    <div class="card-detail-sub card-detail-beginner">
                                                        <h4> {{$course_by_cat->level}} </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-price-section">
                                                <div class="card-price">
                                                    <h3>
                                                        @if($course_by_cat->has_discount == 'on')
                                                            {{ ($course_by_cat->is_free == 'on')? __('Free') :  Utility::priceFormat($course_by_cat->price)}}
                                                            <small>
                                                                <del>{{ Utility::priceFormat( $course_by_cat->discount)}}</del>
                                                            </small>
                                                        @else
                                                            {{ ($course_by_cat->is_free == 'on')? __('Free') :  Utility::priceFormat($course_by_cat->price)}}
                                                        @endif
                                                    </h3>
                                                </div>
                                                <div class="add-cart">
                                                    @if(Auth::guard('students')->check())
                                                        @if(in_array($course_by_cat->id,Auth::guard('students')->user()->purchasedCourse()))
                                                            <a href="{{route('store.fullscreen',[$store->slug,Crypt::encrypt($course_by_cat->id),''])}}">
                                                                {{__('Start Watching')}}
                                                            </a>
                                                        @else
                                                            <a class="add_to_cart" data-id="{{$course_by_cat->id}}">
                                                                @if($key !== false)
                                                                    <span id="cart-btn-{{$course_by_cat->id}}">{{__('Already in Cart')}}</span>
                                                                @else
                                                                    <span id="cart-btn-{{$course_by_cat->id}}">{{__('Add in Cart')}}</span>
                                                                @endif
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a class="add_to_cart" data-id="{{$course_by_cat->id}}">
                                                            @if($key !== false)
                                                                <span id="cart-btn-{{$course_by_cat->id}}">{{__('Already in Cart')}}</span>
                                                            @else
                                                                <span id="cart-btn-{{$course_by_cat->id}}">{{__('Add in Cart')}}</span>
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
    @endif
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
