<!DOCTYPE html>
<html lang="en" dir="{{env('SITE_RTL') == 'on'?'rtl':''}}">
@php
    $userstore = \App\Models\UserStore::where('store_id', $store->id)->first();
    $settings   =\DB::table('settings')->where('name','company_favicon')->where('created_by', $userstore->user_id)->first();
@endphp
@include('layouts.shophead')
@php
    if(!empty(session()->get('lang')))
    {
        $currantLang = session()->get('lang');
    }else{
        $currantLang = $store->lang;
    }
    $languages= Utility::languages();
@endphp
<body class="loaded">
@include('layouts.shopheader')
@yield('content')
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <div class="modal-title">
                    <h6 class="mb-0" id="modelCommanModelLabel"></h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@if($demoStoreThemeSetting['enable_footer_note'] == 'on' || $demoStoreThemeSetting['enable_footer'] == 'on')
    <footer id="footer-main">
        <div class="container-lg {{($demoStoreThemeSetting['enable_footer_note'] != 'on')?'pt-1':'' }}">
            <div class="row">
                <div class="col col-lg-12">
                    <div class="footer-section">
                        {{--FOOTER 1--}}
                        @if($demoStoreThemeSetting['enable_footer_note'] == 'on')
                            <div class="footer-logo">
                                <a href="{{route('store.slug',$store->slug)}}">
                                    @if(!empty($demoStoreThemeSetting['footer_logo']))
                                        <img src="{{asset('assets/img/lmsgo-logo.svg')}}" alt="lmsgo-logo" class="img-fluid">
                                    @else
                                        <img src="{{asset(Storage::url('uploads/store_logo/'.$demoStoreThemeSetting['footer_logo']))}}" alt="Footer logo" style="height: 70px;">
                                    @endif
                                </a>
                                <p>{{$demoStoreThemeSetting['footer_note']}}</p>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    @if($page_slug_urls->count()>0)
                                        <li class="contact menu-item">
                                            @foreach($page_slug_urls as $k=>$page_slug_url)
                                                @if($page_slug_url->enable_page_header == 'on')
                                                    <a href="{{env('APP_URL') . '/page/' . $page_slug_url->slug}}">{{ucfirst($page_slug_url->name)}}</a>
                                                @endif
                                            @endforeach
                                        </li>
                                    @endif
                                    @if($store->blog_enable == 'on' && $blog->count()>0)
                                        <li class="contact menu-item">
                                            <a href="{{route('store.blog',$store->slug)}}">{{__('Blog')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        @if($demoStoreThemeSetting['enable_footer'] == 'on')
                            <div class="footer-try  {{($demoStoreThemeSetting['enable_footer_note'] == 'on')?'delimiter-top mt-2':'' }}">
                                <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                                    @if(isset($demoStoreThemeSetting['email']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="mailto:{{$demoStoreThemeSetting['email']}}" target="_blank">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($demoStoreThemeSetting['whatsapp']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="https://wa.me/{{$demoStoreThemeSetting['whatsapp']}}" target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($demoStoreThemeSetting['facebook']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$demoStoreThemeSetting['facebook']}}" target="_blank">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($demoStoreThemeSetting['instagram']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$demoStoreThemeSetting['instagram']}}" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($demoStoreThemeSetting['twitter']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$demoStoreThemeSetting['twitter']}}" target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($demoStoreThemeSetting['youtube']))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$demoStoreThemeSetting['youtube']}}" target="_blank">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
{!! $demoStoreThemeSetting['storejs'] !!}
<!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
<script> app_url = "{{asset('assets/img/')}}" </script>
<script src="{{asset('assets/js/site.core.js')}}"></script>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<!-- notify -->
<script type="text/javascript" src="{{ asset('assets/js/custom.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('assets/libs/swiper/dist/js/swiper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.3.3.5.js')}}"></script>
<!-- site JS -->
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<script src="{{asset('assets/js/site.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
{{--Search--}}
<script>
    $(document).ready(function () {
        $(document).on('click', '#search_icon', function () {

            //FETCH AND SEARCH
            function fetch_course_data(query = '') {
                $.ajax({
                    url: "{{ route('store.searchData',[$store->slug,'__query']) }}".replace('__query', query),
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#search_data_div').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search_box', function () {
                var query = $(this).val();
                /*console.log(query);
                return false;*/
                if (query != '') {
                    fetch_course_data(query);
                } else {
                    $('#search_data_div').html('');
                }

            });
        });
    });
</script>

<div class="container-lg">
    <div class="row">
        <div class="modal fade edit-profile" id="commonModalBlur" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h3 class="modal-title profile-heading" id="modelCommanModelLabel"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @php
        $store_settings = \App\Models\Store::where('slug',$store->slug)->first();
    @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$store_settings->google_analytic}}"></script>

    {!! $store_settings->storejs !!}

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{ $store_settings->google_analytic }}');
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
        fbq('init', '{{$store_settings->fbpixel_code}}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript={{$store_settings->fbpixel_code}}"
    /></noscript>

@stack('script-page')
@if($message = Session::get('success'))
    <script>
        show_toastr('Success', '{!! $message !!}', 'success');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('Error', '{!! $message !!}', 'error');
    </script>
@endif
</body>
</html>
