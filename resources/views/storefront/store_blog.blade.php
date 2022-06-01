@extends('layouts.shopfront')
@section('page-title')
    {{ __('Blog') }} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{ __('Blog') }}
@endsection
@section('content')
    <div class="course-page hero-section tutor-page blog-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="course-page-text pt-100">
                        <div class="category-heading">
                            <h2>{{__('Blog')}}</h2>
                            <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="course-second chapter-original-video">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-12 col-lg-12 p-0">
                    <div class="categories-card">
                        @foreach($blogs as $blog)
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                <div class="card-section">
                                    <div class="card">
                                        <div class="card-main">
                                            <div class="card-img">
                                                <div class="card-img-main">
                                                    <a href="{{route('store.store_blog_view',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($blog->id)])}}">
                                                        @if(!empty($blog->blog_cover_image) && file_exists(asset(Storage::url('uploads/store_logo/'.$blog->blog_cover_image))))
                                                            <img src="{{asset(Storage::url('uploads/store_logo/'.$blog->blog_cover_image))}}" alt="card" class="img-fluid">
                                                        @else
                                                            <img src="{{asset('assets/img/card-img.svg')}}" alt="card" class="img-fluid">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="card-tag">
                                                    <div class="design-tag text-center">
                                                        <span>{{__('Articles')}}</span>
                                                    </div>
                                                    <div class="like-tag">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-text">
                                                <div class="card-heading">
                                                    <a href="{{route('store.store_blog_view',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($blog->id)])}}">
                                                        <h4>{{$blog->title}}</h4>
                                                    </a>
                                                </div>
                                                <div class="card-detail-main">
                                                    <div class="card-detail">
                                                        <div class="card-detail-sub">
                                                            <div class="card-icon">
                                                            </div>
                                                            <h4></h4>
                                                        </div>
                                                        <div class="card-detail-sub">
                                                            <h4>{{ Utility::dateFormat($blog->created_at)}}</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-price-section articles-section">
                                                    <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                        Lorem Ipsum has been the industrys standard')}}...</p>
                                                </div>
                                                <div class="card-price-section">
                                                    <div class="add-cart w-100">
                                                        <a href="{{route('store.store_blog_view',[$store->slug,\Illuminate\Support\Facades\Crypt::encrypt($blog->id)])}}" class="d-flex align-items-center justify-content-center">
                                                            {{__('Read More')}}
                                                        </a>
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
    @if($store->enable_subscriber == 'on')
        <section class="newsletter-section">
            <div class="container-lg">
                <div class="row">
                    <div class="col col-lg-12 theme-bg-color newsletter-part">
                        <div class="col col-lg-7 col-md-6 col-sm-12">
                            <div class="newsletter-section">
                                <div class="newsletter-text">
                                    <h4>{{__('Subscribe on Newsletter')}}</h4>
                                    <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum is simply dummy text of the printing and typesetting industry')}}. </p>
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
        $(document).ready(function () {
            var blog = {{sizeof($blogs)}};
            if (blog < 1) {
                window.location.href = "{{route('store.slug',$slug)}}";
            }
        });
    </script>
@endpush
