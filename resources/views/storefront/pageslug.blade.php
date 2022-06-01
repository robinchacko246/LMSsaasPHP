@extends('layouts.shopfront')
@section('page-title')
    {{ ucfirst($pageoption->name) }} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{ ucfirst($pageoption->name) }}
@endsection
@section('content')
    <div class="course-page hero-section tutor-page blog-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7 col-sm-12">
                    <div class="course-page-text pt-100">
                        <div class="course-back">
                            <a href="{{route('store.slug',$store->slug)}}">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                {{__('Back to home')}}
                            </a>
                        </div>
                        <div class="category-heading">
                            <h2>{{ ucfirst($pageoption->name) }}</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-student">
        <div class="container-lg mt-5">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <p class="paragraph">
                        {!! $pageoption->contents !!}
                    </p>
                </div>
            </div>
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
@endpush


