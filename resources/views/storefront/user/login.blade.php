@extends('storefront.user.user')
@section('page-title')
    {{__('Login')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@section('head-title')
    {{__('Student Login')}}
@endsection
@section('content')
    <div class="hero-section login-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="login-form">
                        <div class="categories-heading">
                            <h2>{{__('Student')}} <span> {{__('login')}} </span></h2>
                        </div>
                        {!! Form::open(array('route' => array('student.login', $slug,(!empty($is_cart) && $is_cart==true)?$is_cart:false),'class'=>'login-form-main py-5'),['method'=>'POST']) !!}
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1" class="form-label">{{__('username')}}</label>
                            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1" class="form-label">{{__('Password')}}</label>
                            {{Form::password('password',array('class'=>'form-control','id'=>'exampleInputPassword1','placeholder'=>__('Enter Your Password')))}}
                        </div>
                        <div class="log_in_btn form-group mt-5 mb-3 d-flex align-items-center">
                            <button type="submit" class="btn login-btn">{{__('Log In')}}</button>
                            <p>{{__('By using the system, you accept the')}} <a href=""> {{__('Privacy Policy')}} </a> {{__('and')}} <a href=""> {{__('System Regulations')}}. </a></p>
                        </div>
                        {{Form::close()}}
                        {{__('Dont have account ?')}}
                        <a href="{{route('store.usercreate',$slug)}}" class="login-form-main-a">{{__('Register')}}</a>
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
    <script>
        if ('{!! !empty($is_cart) && $is_cart==true !!}') {
            show_toastr('Error', 'You need to login!', 'error');
        }
    </script>
@endpush
