@extends('storefront.user.user')
@section('page-title')
    {{__('Register')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{__('Student Register')}}
@endsection
@section('content')
    <div class="hero-section login-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="login-form">
                        <div class="categories-heading">
                            <h2>{{__('Student')}} <span> {{__('Register')}} </span></h2>
                        </div>
                        {!! Form::open(array('route' => array('store.userstore', $slug),'class'=>'login-form-main py-5'), ['method' => 'post']) !!}
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">{{__('Full Name')}}</label>
                            <input name="name" class="form-control form-control-lg" type="text" placeholder="{{__('Full Name *')}}" required="required">
                        </div>
                        @error('name')
                        <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">{{__('Email')}}</label>
                            <input name="email" class="form-control form-control-lg" type="email" placeholder="{{__('Email *')}}" required="required">
                        </div>
                        @error('email')
                        <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">{{__('Number')}}</label>
                            <input name="phone_number" class="form-control form-control-lg" type="text" placeholder="{{__('Number *')}}" required="required">
                        </div>
                        @error('number')
                        <span class="error invalid-email text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">{{__('Password')}}</label>
                            <input name="password" class="form-control form-control-lg" type="password" placeholder="{{__('Password *')}}" required="required">
                        </div>
                        @error('password')
                        <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">{{__('Confirm Password')}}</label>
                            <input name="password_confirmation" class="form-control form-control-lg" type="password" placeholder="{{__('Confirm Password *')}}" required="required">
                        </div>
                        @error('password_confirmation')
                        <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="log_in_btn form-group mt-5 mb-3 d-flex align-items-center">
                            <button type="submit" class="btn login-btn">{{__('Register')}}</button>
                            <p>{{ __('By using the system, you accept the')}} <a href=""> {{__('Privacy Policy')}} </a> and <a href=""> {{__('System Regulations')}}. </a></p>
                        </div>
                        {!! Form::close() !!}
                        {{__('Already registered ?')}}
                        <a href="{{route('student.loginform',$slug)}}" class="text-dark">{{__('Login')}}</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="hero-section-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page')
@endpush
