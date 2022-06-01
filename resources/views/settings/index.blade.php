@extends('layouts.admin')
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo= Utility::getValByName('company_logo');
    $company_favicon= Utility::getValByName('company_favicon');
    $store_logo=asset(Storage::url('uploads/store_logo/'));
    $lang= Utility::getValByName('default_language');
    if(Auth::user()->type == 'Owner')
    {
        $store_lang=$store_settings->lang;
    }
@endphp
@section('page-title')
    @if(Auth::user()->type == 'super admin')
        {{__('Setting')}}
    @else
        {{__('Store Setting')}}
    @endif
@endsection
@section('title')
    <div class="d-inline-block">
        @if(Auth::user()->type == 'super admin')
            <h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{__('Setting')}}</h5>
        @else
            <h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{__('Store Setting')}}</h5>
        @endif
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Home')}}</a></li>
@endsection
@section('action-btn')
@endsection
@section('filter')
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('assets/libs/summernote/summernote-bs4.css')}}">
    <style>
        hr {
            margin: 8px;
        }
    </style>
@endpush
@push('script-page')
    <script src="{{asset('assets/libs/summernote/summernote-bs4.js')}}"></script>
@endpush
@section('content')
    <div class="mt-4">
        <div class="card">
            <ul class="nav nav-tabs nav-overflow profile-tab-list" role="tablist">
                @if(Auth::user()->type == 'Owner')
                    <li class="nav-item ml-4">
                        <a href="#store_setting" id="store_setting_tab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-store mr-2"></i>
                            {{__('Store Settings')}}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#store_theme_setting" id="theme_setting_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-cog mr-2"></i>{{__('Store Theme Setting')}}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#store_site_setting" id="site_setting_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-cog mr-2"></i>{{__('Site Setting')}}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#store_payment-setting" id="payment-setting_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fab fa-cc-visa mr-2"></i>{{__('Store Payment')}}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#store_email_setting" id="email_store_setting" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-envelope mr-2"></i>{{__('Store Email Setting')}}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#certificate_setting" id="certificate_setting1" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-certificate mr-2"></i>{{ __('Certificate Setting') }}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#slack-setting" id="slack_store_setting" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fab fa-slack mr-2"></i>{{ __('Slack Setting') }}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#telegram-setting" id="telegram_store_setting" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fab fa-telegram-plane mr-2"></i>{{ __('Telegram Setting') }}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#recaptcha-settings" id="system_setting_tab" class="nav-link" data-toggle="tab" role="tab"
                            aria-controls="home" aria-selected="true">
                            <i class="fas fa-cog mr-2"></i>{{__('ReCaptcha Setting')}}
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                @if(Auth::user()->type == 'Owner')
                    <div class="tab-pane fade show active" id="store_setting" role="tabpanel" aria-labelledby="orders-tab">
                        {{Form::model($store_settings,array('route'=>array('settings.store',$store_settings['id']),'method'=>'POST','enctype' => "multipart/form-data"))}}
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="logo" class="form-control-label">{{ __('Logo') }}</label>
                                        <input type="file" name="logo" id="logo" class="custom-input-file">
                                        <label for="logo">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('Choose a file')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-center mt-3">
                                    <div class="logstore_settingso-div">
                                        @if(!empty($store_settings['logo']))
                                            <img src="{{$store_logo.'/'.(isset($store_settings['logo']) && !empty($store_settings['logo'])?$store_settings['logo']:'logo.png')}}" width="170px" class="img_setting">
                                        @else
                                            <img src="{{$store_logo.'/'.'logo.png'}}" width="170px" class="img_setting">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    @error('logo')
                                    <div class="row">
                                    <span class="invalid-logo" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="invoice_logo" class="form-control-label">{{ __('Invoice Logo') }}</label>
                                        <input type="file" name="invoice_logo" id="invoice_logo" class="custom-input-file">
                                        <label for="invoice_logo">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('Choose a file')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-center mt-3">
                                    <div class="logstore_settingso-div">
                                        <img src="{{$store_logo.'/'.(isset($store_settings['invoice_logo']) && !empty($store_settings['invoice_logo'])?$store_settings['invoice_logo']:'invoice_logo.png')}}" width="170px" class="img_setting">
                                    </div>
                                </div>
                                <div class="col-12">
                                    @error('invoice_logo')
                                    <div class="row">
                                    <span class="invalid-invoice_logo" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('store_name',__('Store Name'),array('class'=>'form-control-label')) }}
                                    {!! Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Store Name'))) !!}
                                    @error('store_name')
                                    <span class="invalid-store_name" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('email',__('Email'),array('class'=>'form-control-label')) }}
                                    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Email')))}}
                                    @error('email')
                                    <span class="invalid-email" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="col-6 py-4">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-primary {{ ($store_settings['enable_storelink'] == 'on') ? 'active' : '' }}">
                                            <input type="radio" class="domain_click" name="enable_domain" value="enable_storelink" id="enable_storelink" {{ ($store_settings['enable_storelink'] == 'on') ? 'checked' : '' }}"> {{__('Store Link')}}
                                        </label>
                                        <label class="btn btn-primary {{ ($store_settings['enable_domain'] == 'on') ? 'active' : '' }}">
                                            <input type="radio" class="domain_click" name="enable_domain" value="enable_domain" id="enable_domain" {{ ($store_settings['enable_domain'] == 'on') ? 'checked' : '' }} > {{__('Domain')}}
                                        </label>
                                        <label class="btn btn-primary {{ ($store_settings['enable_subdomain'] == 'on') ? 'active' : '' }}">
                                            <input type="radio" class="domain_click" name="enable_domain" value="enable_subdomain" id="enable_subdomain" {{ ($store_settings['enable_subdomain'] == 'on') ? 'checked' : '' }}> {{__('Sub Domain')}}
                                        </label>
                                    </div>
                                    <div class="text-sm" id="domainnote" style="display: none">{{__('Note : Before add custom domain, your domain A record is pointing to our server IP :')}}{{$serverIp}} <br>
                                    </div>
                                </div>
                                <div class="form-group col-md-6" id="StoreLink" style="{{ ($store_settings['enable_storelink'] == 'on') ? 'display: block':'display: none' }}">
                                    {{Form::label('store_link',__('Store Link'),array('class'=>'form-control-label')) }}
                                    <div class="input-group">
                                        <input type="text" value="{{ $store_settings['store_url'] }}" id="myInput" class="form-control d-inline-block" aria-label="Recipient's username" aria-describedby="button-addon2" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" onclick="myFunction()" id="button-addon2"><i class="far fa-copy"></i> {{__('Copy Link')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 domain" style="{{ ($store_settings['enable_domain'] == 'on') ? 'display:block':'display:none' }}">
                                    {{Form::label('store_domain',__('Custom Domain'),array('class'=>'form-control-label')) }}
                                    {{Form::text('domains',$store_settings['domains'],array('class'=>'form-control','placeholder'=>__('xyz.com')))}}
                                </div>
                                <div class="form-group col-md-6 sundomain" style="{{ ($store_settings['enable_subdomain'] == 'on') ? 'display:block':'display:none' }}">
                                    {{Form::label('store_subdomain',__('Sub Domain'),array('class'=>'form-control-label')) }}
                                    <div class="input-group">
                                        {{Form::text('subdomain',$store_settings['slug'],array('class'=>'form-control','placeholder'=>__('Enter Domain'),'readonly'))}}
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">.{{$subdomain_name}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('tagline',__('Tagline'),array('class'=>'form-control-label')) }}
                                    {{Form::text('tagline',null,array('class'=>'form-control','placeholder'=>__('Tagline')))}}
                                    @error('tagline')
                                    <span class="invalid-tagline" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('address',__('Address'),array('class'=>'form-control-label')) }}
                                    {{Form::text('address',null,array('class'=>'form-control','placeholder'=>__('Address')))}}
                                    @error('address')
                                    <span class="invalid-address" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('city',__('City'),array('class'=>'form-control-label')) }}
                                    {{Form::text('city',null,array('class'=>'form-control','placeholder'=>__('City')))}}
                                    @error('city')
                                    <span class="invalid-city" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('state',__('State'),array('class'=>'form-control-label')) }}
                                    {{Form::text('state',null,array('class'=>'form-control','placeholder'=>__('State')))}}
                                    @error('state')
                                    <span class="invalid-state" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('zipcode',__('Zipcode'),array('class'=>'form-control-label')) }}
                                    {{Form::text('zipcode',null,array('class'=>'form-control','placeholder'=>__('Zipcode')))}}
                                    @error('zipcode')
                                    <span class="invalid-zipcode" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('country',__('Country'),array('class'=>'form-control-label')) }}
                                    {{Form::text('country',null,array('class'=>'form-control','placeholder'=>__('Country')))}}
                                    @error('country')
                                    <span class="invalid-country" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('store_default_language',__('Store Default Language'), array('class'=>'form-control-label')) }}
                                    <div class="changeLanguage">
                                        <select name="store_default_language" id="store_default_language" class="form-control custom-select" data-toggle="select">
                                            @foreach( Utility::languages() as $language)
                                                <option @if($store_lang == $language) selected @endif value="{{$language }}">{{Str::upper($language)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    {{Form::label('enable_rating',__('Rating Display'),array('class'=>'form-control-label mb-3')) }}
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="enable_rating" id="enable_rating" {{ ($store_settings['enable_rating'] == 'on') ? 'checked=checked' : '' }}>
                                        <label class="custom-control-label form-control-label" for="enable_rating"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    {{Form::label('blog_enable',__('Blog Menu Dispay'),array('class'=>'form-control-label mb-3')) }}
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="blog_enable" id="blog_enable" {{ ($store_settings['blog_enable'] == 'on') ? 'checked=checked' : '' }}>
                                        <label class="custom-control-label form-control-label" for="blog_enable"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fab fa-google" aria-hidden="true"></i>
                                        {{Form::label('google_analytic',__('Google Analytic'),array('class'=>'form-control-label')) }}
                                        {{Form::text('google_analytic',null,array('class'=>'form-control','placeholder'=>__('UA-XXXXXXXXX-X')))}}
                                        @error('google_analytic')
                                        <span class="invalid-google_analytic" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('storejs',__('Store Custom JS'),array('class'=>'form-control-label')) }}
                                        {{Form::textarea('storejs',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Store Custom JS')))}}
                                        @error('storejs')
                                        <span class="invalid-storejs" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div> 
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('fbpixel',__('Facebook Pixel'),array('class'=>'form-control-label')) }}
                                        {{Form::text('fbpixel',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Facebook Pixel')))}}
                                        @error('fbpixel')
                                        <span class="invalid-fbpixel" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div> 
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('zoom_apikey', __('Zoom API Key'), ['class' => 'form-control-label']) }}
                                        {{ Form::text('zoom_apikey',isset($store_settings['zoom_apikey'])?$store_settings['zoom_apikey']:'', ['class' => 'form-control', 'placeholder' => __('Enter Zoom API Key')]) }}                                            
                                    </div>
                                </div>
                                <div class="col-md-3">   
                                    <div class="form-group">
                                        {{ Form::label('zoom_apisecret', __('Zoom API Secret'), ['class' => 'form-control-label']) }}
                                        {{ Form::text('zoom_apisecret',isset($store_settings['zoom_apisecret'])? $store_settings['zoom_apisecret']:'', ['class' => 'form-control', 'placeholder' => __('Enter Zoom API Secret')]) }}                                            
                                    </div>
                                </div>
                                <div class="col-12 pt-4">
                                    <h5 class="h6 mb-0">{{__('Email Subscriber Setting')}}</h5>
                                    <small>{{__('This detail will use to change header setting.')}}</small>
                                    <hr class="my-4">
                                </div>
                                <div class="col-12 py-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="enable_subscriber" id="enable_subscriber" {{ ($store_settings['enable_subscriber'] == 'on') ? 'checked=checked' : '' }}>
                                        <label class="custom-control-label form-control-label" for="enable_subscriber">{{__('Display Email Subscriber Box')}}</label>
                                    </div>
                                </div>
                                <div id="subscriber" class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="logo" class="form-control-label">{{ __('Subscriber Background Image') }}</label>
                                                <input type="file" name="sub_img" id="sub_img" class="custom-input-file">
                                                <label for="sub_img">
                                                    <i class="fa fa-upload"></i>
                                                    <span>{{__('Choose a file')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{Form::label('subscriber_title',__('Subscriber Title'),array('class'=>'form-control-label')) }}
                                                {{Form::text('subscriber_title',null,array('class'=>'form-control','placeholder'=>__('Enter Subscriber Title')))}}
                                                @error('subscriber_title')
                                                <span class="invalid-subscriber_title" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{Form::label('sub_title',__('Subscriber Sub Title'),array('class'=>'form-control-label')) }}
                                                {{Form::text('sub_title',null,array('class'=>'form-control','placeholder'=>__('Enter Subscriber Sub Title')))}}
                                                @error('sub_title')
                                                <span class="invalid-sub_title" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-md-12">
                                    {{Form::label('about',__('About'),array('class'=>'form-control-label')) }}
                                    {{Form::textarea('about',null,array('class'=>'form-control summernote-simple','rows'=>3,'placehold   er'=>__('About')))}}
                                    @error('about')
                                    <span class="invalid-about" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div> --}}
                                <div class="col-12 pt-4">
                                    <h5 class="h6 mb-0">{{__('Footer Note')}}</h5>
                                    <small>{{__('This detail will use for make explore social media.')}}</small>
                                    <hr class="my-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fas fa-envelope"></i>
                                        {{Form::label('email',__('Email'),array('class'=>'form-control-label')) }}
                                        {{Form::text('email',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Email')))}}
                                        @error('email')
                                        <span class="invalid-email" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                        {{Form::label('whatsapp',__('Whatsapp'),array('class'=>'form-control-label')) }}
                                        {{Form::text('whatsapp',null,array('class'=>'form-control','rows'=>3,'placeholder'=>'https://wa.me/1XXXXXXXXXX'))}}
                                        @error('whatsapp')
                                        <span class="invalid-whatsapp" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fab fa-facebook-square" aria-hidden="true"></i>
                                        {{Form::label('facebook',__('Facebook'),array('class'=>'form-control-label')) }}
                                        {{Form::text('facebook',null,array('class'=>'form-control','rows'=>3,'placeholder'=>'https://www.facebook.com/'))}}
                                        @error('facebook')
                                        <span class="invalid-facebook" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fab fa-instagram" aria-hidden="true"></i>
                                        {{Form::label('instagram',__('Instagram'),array('class'=>'form-control-label')) }}
                                        {{Form::text('instagram',null,array('class'=>'form-control','placeholder'=>'https://www.instagram.com/'))}}
                                        @error('instagram')
                                        <span class="invalid-instagram" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fab fa-twitter" aria-hidden="true"></i>
                                        {{Form::label('twitter',__('Twitter'),array('class'=>'form-control-label')) }}
                                        {{Form::text('twitter',null,array('class'=>'form-control','placeholder'=>'https://twitter.com/'))}}
                                        @error('twitter')
                                        <span class="invalid-twitter" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fab fa-youtube" aria-hidden="true"></i>
                                        {{Form::label('youtube',__('Youtube'),array('class'=>'form-control-label')) }}
                                        {{Form::text('youtube',null,array('class'=>'form-control','placeholder'=>'https://www.youtube.com/'))}}
                                        @error('youtube')
                                        <span class="invalid-youtube" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fas    fa-copyright" aria-hidden="true"></i>
                                        {{Form::label('footer_note',__('Footer Note'),array('class'=>'form-control-label')) }}
                                        {{Form::text('footer_note',null,array('class'=>'form-control','placeholder'=>__('Footer Note')))}}
                                        @error('footer_note')
                                        <span class="invalid-footer_note" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-8">
                                    {{Form::label('storejs',__('Store Custom JS'),array('class'=>'form-control-label')) }}
                                    {{Form::textarea('storejs',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Store Custom JS')))}}
                                    @error('storejs')
                                    <span class="invalid-storejs" role="alert">
                                         <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-soft-danger btn-icon rounded-pill" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$store_settings->id}}').submit();">
                                        <span class="btn-inner--text">{{__('Delete Store')}}</span>
                                    </button>
                                </div>
                                <div class="col-6 text-right">
                                    {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['ownerstore.destroy', $store_settings->id],'id'=>'delete-form-'.$store_settings->id]) !!}
                    {!! Form::close() !!}

                    <div id="store_theme_setting" class="tab-pane fade show" role="tabpanel" aria-labelledby="orders-tab">
                        {{Form::open(array('route' => array('store.changetheme', $store_settings->id),'method' => 'POST'))}}
                        <div class="card-body">
                            <div class="row">
                                @foreach( Utility::themeOne() as $key => $v)
                                    <div class="col-3 cc-selector mb-2">
                                        <div class="mb-3 screen">
                                            <img src="{{asset(Storage::url('uploads/store_theme/'.$key.'/Home.png'))}}" class="img-center pro_max_width pro_max_height {{$key}}_img">
                                        </div>
                                        <div class="form-group">
                                            <div class="row gutters-xs mx-auto" id="{{$key}}">
                                                @foreach($v as $css => $val)
                                                    <div class="col">
                                                        <label class="colorinput">
                                                            <input name="theme_color" type="radio" value="{{$css}}" data-key="theme{{$loop->iteration}}" data-theme="{{$key}}" data-imgpath="{{$val['img_path']}}" class="colorinput-input" {{(isset($store_settings['store_theme']) && $store_settings['store_theme'] == $css) ? 'checked' : ''}}>
                                                            <span class="colorinput-color" style="background:#{{$val['color']}}"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row card-footer">
                            <div class="col-6">
                                <p class="small">{{__('Note')}} : {{__('you can edit theme after saving')}}</p>
                            </div>
                            <div class="col-6 text-right">
                                {{Form::hidden('themefile',null,array('id'=>'themefile'))}}
                                {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                @endif
                @if(\Auth::user()->type=='Owner')

                    <div id="store_site_setting" class="tab-pane fade show" role="tabpanel" aria-labelledby="orders-tab">
                        {{Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="company_logo" class="form-control-label">{{ __('Logo') }}</label>
                                        <input type="file" name="company_logo" id="company_logo" class="custom-input-file">
                                        <label for="company_logo">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('Choose a file')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-center mt-3">
                                    <div class="logo-div">
                                        <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" width="170px" class="img_setting">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="company_favicon" class="form-control-label">{{ __('Favicon') }}</label>
                                        <input type="file" name="company_favicon" id="company_favicon" class="custom-input-file">
                                        <label for="company_favicon">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('Choose a file')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-center mt-3">
                                    <div class="logo-div">
                                        <img src="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" width="50px" class="img_setting">
                                    </div>
                                </div>
                                <div class="col-12">
                                    @error('logo')
                                    <div class="row">
                                    <span class="invalid-logo" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('title_text',__('Title Text'),array('class'=>'form-control-label')) }}
                                    {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                    @error('title_text')
                                    <span class="invalid-title_text" role="alert">
                                     <strong class="text-danger">{{ $message }}</strong>
                                 </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('footer_text',__('Footer Text'),array('class'=>'form-control-label'))}}
                                    {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                    @error('footer_text')
                                    <span class="invalid-footer_text" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_date_format" class="form-control-label">{{__('Date Format')}}</label>
                                    <select type="text" name="site_date_format" class="form-control selectric" id="site_date_format">
                                        <option value="M j, Y" @if(@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>Jan 1,2015</option>
                                        <option value="d-m-Y" @if(@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>d-m-y</option>
                                        <option value="m-d-Y" @if(@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>m-d-y</option>
                                        <option value="Y-m-d" @if(@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>y-m-d</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_time_format" class="form-control-label">{{__('Time Format')}}</label>
                                    <select type="text" name="site_time_format" class="form-control selectric" id="site_time_format">
                                        <option value="g:i A" @if(@$settings['site_time_format'] == 'g:i A') selected="selected" @endif>10:30 PM</option>
                                        <option value="g:i a" @if(@$settings['site_time_format'] == 'g:i a') selected="selected" @endif>10:30 pm</option>
                                        <option value="H:i" @if(@$settings['site_time_format'] == 'H:i') selected="selected" @endif>22:30</option>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    {{Form::label('display_landing_page_',__('Landing Page Display')) }}
                                    <div class="col-12 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="display_landing_page" id="display_landing_page" {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="display_landing_page"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    {{Form::label('SITE_RTL',__('RTL')) }}
                                    <div class="col-12 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="SITE_RTL" id="SITE_RTL" {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="SITE_RTL"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                        </div>
                        {{Form::close()}}
                    </div>
                    <div class="tab-pane fade show" id="store_payment-setting" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="card-body">
                            {{Form::open(array('route'=>array('owner.payment.setting',$store_settings->slug),'method'=>'post'))}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('currency_symbol',__('Currency Symbol *')) }}
                                        {{Form::text('currency_symbol',$store_settings['currency'],array('class'=>'form-control','required'))}}
                                        @error('currency_symbol')
                                        <span class="invalid-currency_symbol" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('currency',__('Currency *')) }}
                                        {{Form::text('currency',$store_settings['currency_code'],array('class'=>'form-control font-style','required'))}}
                                        {{__('Note: Add currency code as per three-letter ISO code.')}}
                                        <small>
                                            <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a>
                                        </small>
                                        @error('currency')
                                        <span class="invalid-currency" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="customRadio5" name="currency_symbol_position" value="pre" class="custom-control-input" @if(@$store_settings['currency_symbol_position'] == 'pre') checked @endif>
                                                    <label class="custom-control-label" for="customRadio5">{{__('Pre')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="customRadio6" name="currency_symbol_position" value="post" class="custom-control-input" @if(@$store_settings['currency_symbol_position'] == 'post') checked @endif>
                                                    <label class="custom-control-label" for="customRadio6">{{__('Post')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">{{__('Currency Symbol Space')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="customRadio7" name="currency_symbol_space" value="with" class="custom-control-input" @if(@$store_settings['currency_symbol_space'] == 'with') checked @endif>
                                                    <label class="custom-control-label" for="customRadio7">{{__('With Space')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="customRadio8" name="currency_symbol_space" value="without" class="custom-control-input" @if(@$store_settings['currency_symbol_space'] == 'without') checked @endif>
                                                    <label class="custom-control-label" for="customRadio8">{{__('Without Space')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" pb-3">
                                <hr>
                            </div>
                            <div id="accordion-2" class="accordion accordion-spaced">

                                <!-- Bank transfer -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-3" data-toggle="collapse" role="button" data-target="#collapse-2-5" aria-expanded="false" aria-controls="collapse-2-5">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Bank Transfer')}}</h6>
                                    </div>
                                    <div id="collapse-2-5" class="collapse" aria-labelledby="heading-2-5" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5 mb-0">{{__('Bank Transfer')}}</h5>
                                                    <small> {{__('Note: Input your bank details including bank name.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="enable_bank" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="enable_bank" id="enable_bank" {{ $store_settings['enable_bank'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="enable_bank">{{__('Enable Bank Transfer')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <textarea type="text" name="bank_number" id="bank_number" class="form-control" value="" placeholder="{{ __('Bank Transfer Number') }}">{{$store_settings['bank_number']}}   </textarea>
                                                        @if ($errors->has('bank_number'))
                                                            <span class="invalid-feedback d-block">
                                                            {{ $errors->first('bank_number') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Strip -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-2" data-toggle="collapse" role="button" data-target="#collapse-2-2" aria-expanded="false" aria-controls="collapse-2-2">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Stripe')}}</h6>
                                    </div>
                                    <div id="collapse-2-2" class="collapse" aria-labelledby="heading-2-2" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Stripe')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_stripe_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_stripe_enabled" id="is_stripe_enabled" {{ isset($store_payment_setting['is_stripe_enabled']) && $store_payment_setting['is_stripe_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_stripe_enabled">{{__('Enable Stripe')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{Form::label('stripe_key',__('Stripe Key')) }}
                                                        {{Form::text('stripe_key',isset($store_payment_setting['stripe_key'])?$store_payment_setting['stripe_key']:'',['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                                        @error('stripe_key')
                                                        <span class="invalid-stripe_key" role="alert">
                                                                                             <strong class="text-danger">{{ $message }}</strong>
                                                                                         </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{Form::label('stripe_secret',__('Stripe Secret')) }}
                                                        {{Form::text('stripe_secret',isset($store_payment_setting['stripe_secret'])?$store_payment_setting['stripe_secret']:'',['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                                        @error('stripe_secret')
                                                        <span class="invalid-stripe_secret" role="alert">
                                                             <strong class="text-danger">{{ $message }}</strong>
                                                         </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paypal -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-3" data-toggle="collapse" role="button" data-target="#collapse-2-3" aria-expanded="false" aria-controls="collapse-2-3">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('PayPal')}}</h6>
                                    </div>
                                    <div id="collapse-2-3" class="collapse" aria-labelledby="heading-2-3" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('PayPal')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_paypal_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_paypal_enabled" id="is_paypal_enabled" {{ isset($store_payment_setting['is_paypal_enabled']) && $store_payment_setting['is_paypal_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_paypal_enabled">{{__('Enable Paypal')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-primary btn-sm {{$store_settings['paypal_mode'] == 'sandbox' ? 'active' : ''}}">
                                                            <input type="radio" name="paypal_mode" value="sandbox" {{ isset($store_payment_setting['paypal_mode']) && $store_settings['paypal_mode'] == '' || isset($store_payment_setting['paypal_mode']) && $store_settings['paypal_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                        </label>
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['paypal_mode']) && $store_payment_setting['paypal_mode'] == 'live' ? 'active' : ''}}">
                                                            <input type="radio" name="paypal_mode" value="live" {{ isset($store_payment_setting['paypal_mode']) && $store_settings['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                                        <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{isset($store_settings['paypal_client_id'])?$store_settings['paypal_client_id']:''}}" placeholder="{{ __('Client ID') }}"/>
                                                        @if ($errors->has('paypal_client_id'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paypal_client_id') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                                        <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{isset($store_settings['paypal_secret_key'])?$store_settings['paypal_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                        @if ($errors->has('paypal_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paypal_secret_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paystack -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-6" data-toggle="collapse" role="button" data-target="#collapse-2-6" aria-expanded="false" aria-controls="collapse-2-6">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paystack')}}</h6>
                                    </div>
                                    <div id="collapse-2-6" class="collapse" aria-labelledby="heading-2-6" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Paystack')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_paystack_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_paystack_enabled" id="is_paystack_enabled" {{ isset($store_payment_setting['is_paystack_enabled']) && $store_payment_setting['is_paystack_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_paystack_enabled">{{__('Enable Paystack')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_client_id">{{ __('Public Key') }}</label>
                                                        <input type="text" name="paystack_public_key" id="paystack_public_key" class="form-control" value="{{isset($store_payment_setting['paystack_public_key']) ? $store_payment_setting['paystack_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                        @if ($errors->has('paystack_public_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paystack_public_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                        <input type="text" name="paystack_secret_key" id="paystack_secret_key" class="form-control" value="{{isset($store_payment_setting['paystack_secret_key']) ? $store_payment_setting['paystack_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                        @if ($errors->has('paystack_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paystack_secret_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- FLUTTERWAVE -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-7" data-toggle="collapse" role="button" data-target="#collapse-2-7" aria-expanded="false" aria-controls="collapse-2-7">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Flutterwave')}}</h6>
                                    </div>
                                    <div id="collapse-2-7" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Flutterwave')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_flutterwave_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_flutterwave_enabled" id="is_flutterwave_enabled" {{ isset($store_payment_setting['is_flutterwave_enabled'])  && $store_payment_setting['is_flutterwave_enabled']== 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_flutterwave_enabled">{{__('Enable Flutterwave')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_client_id">{{ __('Public Key') }}</label>
                                                        <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" class="form-control" value="{{isset($store_payment_setting['flutterwave_public_key'])?$store_payment_setting['flutterwave_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                        @if ($errors->has('flutterwave_public_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('flutterwave_public_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                        <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key" class="form-control" value="{{isset($store_payment_setting['flutterwave_secret_key'])?$store_payment_setting['flutterwave_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                        @if ($errors->has('flutterwave_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('flutterwave_secret_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Razorpay -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-8" aria-expanded="false" aria-controls="collapse-2-8">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Razorpay')}}</h6>
                                    </div>
                                    <div id="collapse-2-8" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Razorpay')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_razorpay_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_razorpay_enabled" id="is_razorpay_enabled" {{ isset($store_payment_setting['is_razorpay_enabled']) && $store_payment_setting['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_razorpay_enabled">{{__('Enable Razorpay')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_client_id">{{ __('Public Key') }}</label>

                                                        <input type="text" name="razorpay_public_key" id="razorpay_public_key" class="form-control" value="{{ isset($store_payment_setting['razorpay_public_key'])?$store_payment_setting['razorpay_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                        @if ($errors->has('razorpay_public_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('razorpay_public_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                        <input type="text" name="razorpay_secret_key" id="razorpay_secret_key" class="form-control" value="{{ isset($store_payment_setting['razorpay_secret_key'])?$store_payment_setting['razorpay_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                        @if ($errors->has('razorpay_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('razorpay_secret_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paytm -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-14" data-toggle="collapse" role="button" data-target="#collapse-2-14" aria-expanded="false" aria-controls="collapse-2-14">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paytm')}}</h6>
                                    </div>
                                    <div id="collapse-2-14" class="collapse" aria-labelledby="heading-2-14" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Paytm')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_paytm_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_paytm_enabled" id="is_paytm_enabled" {{ isset($store_payment_setting['is_paytm_enabled']) && $store_payment_setting['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_paytm_enabled">{{__('Enable Paytm')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paytm Environment')}}</label> <br>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['paytm_mode']) && $store_payment_setting['paytm_mode'] == 'local' ? 'active' : ''}}">
                                                            <input type="radio" name="paytm_mode" value="local" {{ isset($store_payment_setting['paytm_mode']) && $store_payment_setting['paytm_mode'] == '' || isset($store_payment_setting['paytm_mode']) && $store_payment_setting['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>{{__('Local')}}
                                                        </label>
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['paytm_mode']) && $store_payment_setting['paytm_mode'] == 'live' ? 'active' : ''}}">
                                                            <input type="radio" name="paytm_mode" value="production" {{ isset($store_payment_setting['paytm_mode']) && $store_payment_setting['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>{{__('Production')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="paytm_public_key">{{ __('Merchant ID') }}</label>
                                                        <input type="text" name="paytm_merchant_id" id="paytm_merchant_id" class="form-control" value="{{isset($store_payment_setting['paytm_merchant_id'])? $store_payment_setting['paytm_merchant_id']:''}}" placeholder="{{ __('Merchant ID') }}"/>
                                                        @if ($errors->has('paytm_merchant_id'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_merchant_id') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="paytm_secret_key">{{ __('Merchant Key') }}</label>
                                                        <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" class="form-control" value="{{ isset($store_payment_setting['paytm_merchant_key']) ? $store_payment_setting['paytm_merchant_key']:''}}" placeholder="{{ __('Merchant Key') }}"/>
                                                        @if ($errors->has('paytm_merchant_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_merchant_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="paytm_industry_type">{{ __('Industry Type') }}</label>
                                                        <input type="text" name="paytm_industry_type" id="paytm_industry_type" class="form-control" value="{{isset($store_payment_setting['paytm_industry_type']) ?$store_payment_setting['paytm_industry_type']:''}}" placeholder="{{ __('Industry Type') }}"/>
                                                        @if ($errors->has('paytm_industry_type'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_industry_type') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mercado Pago-->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-12" data-toggle="collapse" role="button" data-target="#collapse-2-12" aria-expanded="false" aria-controls="collapse-2-12">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mercado Pago')}}</h6>
                                    </div>
                                    <div id="collapse-2-12" class="collapse" aria-labelledby="heading-2-12" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Mercado Pago')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_mercado_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_mercado_enabled" id="is_mercado_enabled" {{isset($store_payment_setting['is_mercado_enabled']) &&  $store_payment_setting['is_mercado_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_mercado_enabled">{{__('Enable Mercado Pago')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <label class="coingate-label form-control-label" for="mercado_mode">{{__('Mercado Mode')}}</label> <br>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['mercado_mode']) && $store_payment_setting['mercado_mode'] == 'sandbox' ? 'active' : ''}}">
                                                            <input type="radio" name="mercado_mode" value="sandbox" {{ isset($store_payment_setting['mercado_mode']) && $store_payment_setting['mercado_mode'] == '' || isset($store_payment_setting['mercado_mode']) && $store_payment_setting['mercado_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                        </label>
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['mercado_mode']) && $store_payment_setting['mercado_mode'] == 'live' ? 'active' : ''}}">
                                                            <input type="radio" name="mercado_mode" value="live" {{ isset($store_payment_setting['mercado_mode']) && $store_payment_setting['mercado_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mercado_access_token">{{ __('Access Token') }}</label>
                                                        <input type="text" name="mercado_access_token" id="mercado_access_token" class="form-control" value="{{isset($store_payment_setting['mercado_access_token']) ? $store_payment_setting['mercado_access_token']:''}}" placeholder="{{ __('Access Token') }}"/>
                                                        @if ($errors->has('mercado_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mercado_access_token') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mollie -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-10" aria-expanded="false" aria-controls="collapse-2-10">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mollie')}}</h6>
                                    </div>
                                    <div id="collapse-2-10" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Mollie')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_mollie_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_mollie_enabled" id="is_mollie_enabled" {{ isset($store_payment_setting['is_mollie_enabled']) && $store_payment_setting['is_mollie_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_mollie_enabled">{{__('Enable Mollie')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mollie_api_key">{{ __('Mollie Api Key') }}</label>
                                                        <input type="text" name="mollie_api_key" id="mollie_api_key" class="form-control" value="{{ isset($store_payment_setting['mollie_api_key'])?$store_payment_setting['mollie_api_key']:''}}" placeholder="{{ __('Mollie Api Key') }}"/>
                                                        @if ($errors->has('mollie_api_key'))
                                                            <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_api_key') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mollie_profile_id">{{ __('Mollie Profile Id') }}</label>
                                                        <input type="text" name="mollie_profile_id" id="mollie_profile_id" class="form-control" value="{{ isset($store_payment_setting['mollie_profile_id'])?$store_payment_setting['mollie_profile_id']:''}}" placeholder="{{ __('Mollie Profile Id') }}"/>
                                                        @if ($errors->has('mollie_profile_id'))
                                                            <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_profile_id') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mollie_partner_id">{{ __('Mollie Partner Id') }}</label>
                                                        <input type="text" name="mollie_partner_id" id="mollie_partner_id" class="form-control" value="{{ isset($store_payment_setting['mollie_partner_id'])?$store_payment_setting['mollie_partner_id']:''}}" placeholder="{{ __('Mollie Partner Id') }}"/>
                                                        @if ($errors->has('mollie_partner_id'))
                                                            <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_partner_id') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skrill -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-13" aria-expanded="false" aria-controls="collapse-2-10">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Skrill')}}</h6>
                                    </div>
                                    <div id="collapse-2-13" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('Skrill')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_skrill_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_skrill_enabled" id="is_skrill_enabled" {{ isset($store_payment_setting['is_skrill_enabled']) && $store_payment_setting['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_skrill_enabled">{{__('Enable Skrill')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="skrill_email">{{ __('Skrill Email') }}</label>
                                                        <input type="email" name="skrill_email" id="skrill_email" class="form-control" value="{{ isset($store_payment_setting['skrill_email'])?$store_payment_setting['skrill_email']:''}}" placeholder="{{ __('Enter Skrill Email') }}"/>
                                                        @if ($errors->has('skrill_email'))
                                                            <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('skrill_email') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CoinGate -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-15" aria-expanded="false" aria-controls="collapse-2-10">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('CoinGate')}}</h6>
                                    </div>
                                    <div id="collapse-2-15" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">
                                                    <h5 class="h5">{{__('CoinGate')}}</h5>
                                                    <small> {{__('Note: This detail will use for make checkout of shopping cart.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_coingate_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_coingate_enabled" id="is_coingate_enabled" {{ isset($store_payment_setting['is_coingate_enabled']) && $store_payment_setting['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_coingate_enabled">{{__('Enable CoinGate')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <label class="coingate-label form-control-label" for="coingate_mode">{{__('CoinGate Mode')}}</label> <br>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['coingate_mode']) == 'sandbox' ? 'active' : ''}}">
                                                            <input type="radio" name="coingate_mode" value="sandbox" {{ isset($store_payment_setting['coingate_mode']) && $store_settings['coingate_mode'] == '' || isset($store_payment_setting['coingate_mode']) && $store_settings['coingate_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                        </label>
                                                        <label class="btn btn-primary btn-sm {{isset($store_payment_setting['coingate_mode']) && $store_payment_setting['coingate_mode'] == 'live' ? 'active' : ''}}">
                                                            <input type="radio" name="coingate_mode" value="live" {{ isset($store_payment_setting['coingate_mode']) && $store_settings['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="coingate_auth_token">{{ __('CoinGate Auth Token') }}</label>
                                                        <input type="text" name="coingate_auth_token" id="coingate_auth_token" class="form-control" value="{{ isset($store_payment_setting['coingate_auth_token'])?$store_payment_setting['coingate_auth_token']:''}}" placeholder="{{ __('CoinGate Auth Token') }}"/>
                                                        @if($errors->has('coingate_auth_token'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('coingate_auth_token') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paymentwall -->
                                <div class="card">
                                    <div class="card-header py-4" id="heading-2-7" data-toggle="collapse" role="button" data-target="#collapse-2-16" aria-expanded="false" aria-controls="collapse-2-7">
                                        <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paymentwall')}}</h6>
                                    </div>
                                    <div id="collapse-2-16" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 py-2">

                                                    <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                </div>
                                                <div class="col-6 py-2 text-right">
                                                    <div class="custom-control custom-switch">
                                                        <input type="hidden" name="is_paymentwall_enabled" value="off">
                                                        <input type="checkbox" class="custom-control-input" name="is_paymentwall_enabled" id="is_paymentwall_enabled" {{ isset($store_payment_setting['is_paymentwall_enabled'])  && $store_payment_setting['is_paymentwall_enabled']== 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="is_paymentwall_enabled">{{__('Enable paymentwall')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentwall_public_key" class="form-control-label">{{ __('Public Key') }}</label>
                                                        <input type="text" name="paymentwall_public_key" id="paymentwall_public_key" class="form-control" value="{{isset($store_payment_setting['paymentwall_public_key'])?$store_payment_setting['paymentwall_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                        @if ($errors->has('paymentwall_public_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paymentwall_public_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentwall_secret_key" class="form-control-label">{{ __('Secret Key') }}</label>
                                                        <input type="text" name="paymentwall_secret_key" id="paymentwall_secret_key" class="form-control form-control-label" value="{{isset($store_payment_setting['paymentwall_secret_key'])?$store_payment_setting['paymentwall_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                        @if ($errors->has('paymentwall_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paymentwall_secret_key') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer text-right">
                                {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="store_email_setting" role="tabpanel" aria-labelledby="orders-tab">
                        {{Form::open(array('route'=>array('owner.email.setting',$store_settings->slug),'method'=>'post'))}}
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_driver',__('Mail Driver')) }}
                                    {{Form::text('mail_driver',$store_settings->mail_driver,array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                    @error('mail_driver')
                                    <span class="invalid-mail_driver" role="alert">
                                     <strong class="text-danger">{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_host',__('Mail Host')) }}
                                    {{Form::text('mail_host',$store_settings->mail_host,array('class'=>'form-control ','placeholder'=>__('Enter Mail Host')))}}
                                    @error('mail_host')
                                    <span class="invalid-mail_driver" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                 </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_port',__('Mail Port')) }}
                                    {{Form::text('mail_port',$store_settings->mail_port,array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                    @error('mail_port')
                                    <span class="invalid-mail_port" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_username',__('Mail Username')) }}
                                    {{Form::text('mail_username',$store_settings->mail_username,array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                    @error('mail_username')
                                    <span class="invalid-mail_username" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_password',__('Mail Password')) }}
                                    {{Form::text('mail_password',$store_settings->mail_password,array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                    @error('mail_password')
                                    <span class="invalid-mail_password" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_encryption',__('Mail Encryption')) }}
                                    {{Form::text('mail_encryption',$store_settings->mail_encryption,array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                    @error('mail_encryption')
                                    <span class="invalid-mail_encryption" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_from_address',__('Mail From Address')) }}
                                    {{Form::text('mail_from_address',$store_settings->mail_from_address,array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                    @error('mail_from_address')
                                    <span class="invalid-mail_from_address" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('mail_from_name',__('Mail From Name')) }}
                                    {{Form::text('mail_from_name',$store_settings->mail_from_name,array('class'=>'form-control','placeholder'=>__('Enter Mail From Name')))}}
                                    @error('mail_from_name')
                                    <span class="invalid-mail_from_name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <a href="#" data-url="{{route('test.mail' )}}" data-ajax-popup="true" data-title="{{__('Send Test Mail')}}" class="btn btn-sm btn-info rounded-pill">
                                        {{__('Send Test Mail')}}
                                    </a>
                                </div>
                                <div class="form-group col-md-6 text-right">
                                    {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                                </div>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div class="tab-pane fade " id="certificate_setting" role="tabpanel" aria-labelledby="orders-tab">
                        <form id="setting-form" method="post" action="{{route('certificate.template.setting')}}">
                            @csrf
                            <div class="col-12 p-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="font-weight-bold">{{__('Certificate Variable')}}</h6>
                                                <div class="col-6 float-left">
                                                    <p class="mb-1">{{__('Store Name')}} : <span class="pull-right text-primary">{header_name}</span></p>
                                                    <p class="mb-1">{{__('Student Name')}} : <span class="pull-right text-primary">{student_name}</span></p>
                                                    <p class="mb-1">{{__('Course Time')}} : <span class="pull-right text-primary">{course_time}</span></p>
                                                    <p class="mb-1">{{__('Course Name')}} : <span class="pull-right text-primary">{course_name}</span></p>
                                                </div>
                                            </div> 
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="storejs" class="form-control-label">{store_name}</label>
                                                    {{Form::text('header_name',$store->header_name,array('class'=>'form-control','placeholder'=>"{header_name}"))}}
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="address"
                                                class="form-control-label">{{ __('Certificate Template') }}</label>
                                                <select class="form-control select2" name="certificate_template">
                                                    @foreach (Utility::templateData()['templates'] as $key => $template)
                                                        <option value="{{ $key }}"
                                                            {{ (isset($store->certificate_template) && $store->certificate_template == $key) ? 'selected' : '' }}>
                                                            {{ $template }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label form-control-label">{{ __('Color Input') }}</label>
                                                <div class="row gutters-xs">
                                                    @foreach (Utility::templateData()['colors'] as $key => $color)
                                                    <div class="col-auto">
                                                        <label class="colorinput">
                                                            <input name="certificate_color" type="radio"
                                                            value="{{ $color['hex'] }}" class="colorinput-input"
                                                            {{ isset($store->certificate_color) && $store->certificate_color == $color['hex'] ? 'checked' : '' }}  data-gradiant='{{ $color['gradiant'] }}'>
                                                            <span class="colorinput-color"
                                                            style="background: #{{$color['hex']}}"></span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="gradiant" id="gradiant" value="{{ $color['gradiant'] }} ">
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-sm btn-primary rounded-pill">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-10">
                                            {{-- @if (isset($store->certificate_color) && !empty($store->certificate_color) && isset($store->certificate_template) && !empty($store->certificate_template)) --}}
                                                <iframe id="certificate_frame" class="certificate_iframe w-100" frameborder="0"
                                                src="{{ route('certificate.preview', [(isset($store->certificate_template) && !empty($store->certificate_template))?$store->certificate_template:'template1', (isset($store->certificate_color) && !empty($store->certificate_color))?$store->certificate_color:'b10d0d'  , (isset($store->certificate_gradiant) && !empty($store->certificate_gradiant))?$store->certificate_gradiant:'color-one']) }}"></iframe>
                                            {{-- @else
                                                <iframe id="certificate_frame" class="certificate_iframe w-100" frameborder="0"
                                                src="{{ route('certificate.preview', ['template1', 'fffff']) }}"></iframe>
                                            @endif --}}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="slack-setting" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="card-body">
                            {{ Form::open(['route' => 'slack.setting','id'=>'setting-form','method'=>'post' ,'class'=>'d-contents']) }}
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="small-title">{{__('Slack Webhook URL')}}</h4>
                                    {{-- {{ dd($notifications) }} --}}
                                    <div class="col-md-8">
                                        {{ Form::text('slack_webhook', isset($notifications['slack_webhook']) ?$notifications['slack_webhook'] :'', ['class' => 'form-control w-100', 'placeholder' => __('Enter Slack Webhook URL'), 'required' => 'required']) }}
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4 mb-2">
                                    <h4 class="small-title">{{__('Module Setting')}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{__('Course create')}}</span> 
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('course_notification', '1',isset($notifications['course_notification']) && $notifications['course_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'course_notification'))}}
                                                <label class="custom-control-label" for="course_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item"> 
                                            <span>{{__('Store create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('store_notification', '1',isset($notifications['store_notification']) && $notifications['store_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'store_notification'))}}
                                                <label class="custom-control-label" for="store_notification"></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{__('Order create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('order_notification', '1',isset($notifications['order_notification']) && $notifications['order_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'order_notification'))}}
                                                <label class="custom-control-label" for="order_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span> {{__('Zoom Meeting create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('zoom_meeting_notification', '1',isset($notifications['zoom_meeting_notification']) && $notifications['zoom_meeting_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'zoom_meeting_notification'))}}
                                                <label class="custom-control-label" for="zoom_meeting_notification"></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer text-right mt-5">
                                <input class="btn btn-sm btn-primary rounded-pill" type="submit" value="Save Changes">
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div> 
                    <div class="tab-pane fade" id="telegram-setting" role="tabpanel">
                        
                        <div class="card-body">
                            {{ Form::open(['route' => 'telegram.setting','id'=>'telegram-setting','method'=>'post' ,'class'=>'d-contents']) }}
                            <div class="row">
                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0">{{__('Telegram AccessToken')}}</label> <br>
                                            {{ Form::text('telegram_accestoken',isset($notifications['telegram_accestoken'])?$notifications['telegram_accestoken']:'', ['class' => 'form-control', 'placeholder' => __('Enter Telegram AccessToken')]) }}
                                        </div>                                    
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0">{{__('Telegram ChatID')}}</label> <br>
                                            {{ Form::text('telegram_chatid',isset($notifications['telegram_chatid'])?$notifications['telegram_chatid']:'', ['class' => 'form-control', 'placeholder' => __('Enter Telegram ChatID')]) }}
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 mb-2">
                                    <h4 class="small-title">{{__('Module Setting')}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{__('Course create')}}</span> 
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('telegram_course_notification', '1',isset($notifications['telegram_course_notification']) && $notifications['telegram_course_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_course_notification'))}}
                                                <label class="custom-control-label" for="telegram_course_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item"> 
                                            <span>{{__('Store create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('telegram_store_notification', '1',isset($notifications['telegram_store_notification']) && $notifications['telegram_store_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_store_notification'))}}
                                                <label class="custom-control-label" for="telegram_store_notification"></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{__('Order create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('telegram_order_notification', '1',isset($notifications['telegram_order_notification']) && $notifications['telegram_order_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_order_notification'))}}
                                                <label class="custom-control-label" for="telegram_order_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span> {{__('Zoom Meeting create')}}</span>
                                            <div class="custom-control custom-switch float-right">
                                                {{Form::checkbox('telegram_zoom_meeting_notification', '1',isset($notifications['telegram_zoom_meeting_notification']) && $notifications['telegram_zoom_meeting_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_zoom_meeting_notification'))}}
                                                <label class="custom-control-label" for="telegram_zoom_meeting_notification"></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>                                   
                            </div>                               
                            
                            <div class="card-footer text-right mt-5">
                                <input class="btn btn-sm btn-primary rounded-pill" type="submit" value="Save Changes">
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="recaptcha-settings" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="col-md-12 p-3">
                            {{-- <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{ __('ReCaptcha settings') }}</h4>
                                </div>
                            </div> --}}
                            {{-- <div class="card p-3"> --}}
                                <form method="POST" action="{{ route('recaptcha.settings.store') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="recaptcha_module" id="recaptcha_module" value="yes" {{ env('RECAPTCHA_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="recaptcha_module">
                                                    {{ __('Google Recaptcha') }}
                                                    <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/" target="_blank" class="text-blue">
                                                        <small>({{__('How to Get Google reCaptcha Site and Secret key')}})</small>
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_key" class="form-control-label">{{ __('Google Recaptcha Key') }}</label>
                                            <input class="form-control" placeholder="{{ __('Enter Google Recaptcha Key') }}" name="google_recaptcha_key" type="text" value="{{env('NOCAPTCHA_SITEKEY')}}" id="google_recaptcha_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_secret" class="form-control-label">{{ __('Google Recaptcha Secret') }}</label>
                                            <input class="form-control " placeholder="{{ __('Enter Google Recaptcha Secret') }}" name="google_recaptcha_secret" type="text" value="{{env('NOCAPTCHA_SECRET')}}" id="google_recaptcha_secret">
                                        </div>
                                    </div>
                                    <div class="col-lg-12  text-right">
                                        <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </form>
                            {{-- </div> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    <script src="{{asset('assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js')}}"></script>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', 'Link copied', 'success');
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>
    <script>
        $(document).ready(function () {
            $('.repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            })
        });
        $("#eventBtn").click(function () {
            $("#BigButton").clone(true).appendTo("#fileUploadsContainer").find("input").val("").end();
        });
        $("#testimonial_eventBtn").click(function () {
            $("#BigButton2").clone(true).appendTo("#fileUploadsContainer2").find("input").val("").end();
        });

        $(document).on('click', '#remove', function () {
            var qq = $('.BigButton').length;

            if (qq > 1) {
                var dd = $(this).attr('data-id');

                $(this).parents('#BigButton').remove();
            }
        });

        $(".deleteRecord").click(function () {
            var name = $(this).data("name");
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
                {
                    url: '{{ route('brand.file.delete', [Auth::user()->current_store,'_name']) }}'.replace('_name', name),
                    type: 'DELETE',
                    data: {
                        "name": name,
                        "_token": token,
                    },
                    success: function (response) {
                        show_toastr('Success', response.success, 'success');
                        $('.product_Image[data-value="' + response.name + '"]').remove();
                    }, error: function (response) {
                        show_toastr('Error', response.error, 'error');
                    }
                });
        });

        $(document).on('click', 'input[name="theme_color"]', function () {
            var eleParent = $(this).attr('data-theme');
            $('#themefile').val($(this).attr('data-key'));
            var imgpath = $(this).attr('data-imgpath');
            $('.' + eleParent + '_img').attr('src', imgpath);
        });

        $(document).ready(function () {
            setTimeout(function (e) {
                var checked = $("input[type=radio][name='theme_color']:checked");
                $('#themefile').val(checked.attr('data-key'));
                $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
            }, 300);
        });

        $(document).on("change", "select[name='certificate_template'], input[name='certificate_color']", function () {           
            var template = $("select[name='certificate_template']").val();
            var color = $("input[name='certificate_color']:checked").val();
            var gradiant = $(this).data('gradiant');
            $('#gradiant').val(gradiant);
            $('#certificate_frame').attr('src', '{{url('/certificate/preview')}}/' + template + '/' + color + '/' + gradiant);
        });
    </script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '000000');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

@endpush
