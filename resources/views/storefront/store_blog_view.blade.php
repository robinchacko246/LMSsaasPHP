@extends('layouts.shopfront')
@section('page-title')
    {{__('Blog')}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{__('Blog')}}
@endsection
@section('content')
    <div class="course-page hero-section tutor-page blog-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="course-page-text pt-100">
                        <div class="category-heading">
                            <h2>{{__('Blog')}}</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="course-second chapter-original-video">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <figure class="figure">
                        <img alt="Image placeholder" src="{{asset(Storage::url('uploads/store_logo/'.(!empty($blogs->blog_cover_image)?$blogs->blog_cover_image:'blog_1627384767.jpg')))}}" class="img-fluid rounded hover-translate-y-n3 hover-shadow-lg">
                    </figure>
                    <h4 class="mt-5 text-muted text-center">{{$blogs->title}}</h4>
                    <p class="lead">{!! $blogs->detail !!}</p>
                </div>
            </div>
            @if(!empty($socialblogs) && $socialblogs->enable_social_button == 'on')
                <div id="share" class="text-center"></div>
            @endif
        </div>
    </div>
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
@push('script-page')
    <script>
        $(document).ready(function(){
            var blog = "{{$blogs->title}}";
            if(blog==""){
                window.location.href = "{{route('store.slug',$slug)}}";
            }
        });
    </script>
@endpush


