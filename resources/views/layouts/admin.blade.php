<!DOCTYPE html>
<html lang="en" dir="{{env('SITE_RTL') == 'on'?'rtl':''}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.admin.head')
<body class="application application-offset">
<div class="container-fluid container-application">
    @php
        $users=\Auth::user();
        $currantLang = $users->currentLanguages();
        $languages= Utility::languages();
        $footer_text=isset( Utility::settings()['footer_text']) ? Utility::settings()['footer_text'] : '';
    @endphp
    <div class="main-content position-relative">

        @include('partials.admin.header')

        <div class="page-content">

            @include('partials.admin.content')

        </div>
        <div class="footer pt-5 pb-4 footer-light" id="footer-main">
            <div class="row text-center text-sm-left align-items-sm-center">
                <div class="col-sm-6">
                    <p class="text-sm mb-0">{{ $footer_text }}</p>
                </div>
                <div class="col-sm-6 mb-md-0">
                    <ul class="nav justify-content-center justify-content-md-end">
                        <li class="nav-item dropdown border-right">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="h6 text-sm mb-0"><i class="fas fa-globe-asia"></i>
                                    {{Str::upper($currantLang)}}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                @foreach($languages as $language)
                                    <a href="{{route('change.language',$language)}}" class="dropdown-item @if($language == $currantLang) active-language @endif">
                                        <span> {{Str::upper($language)}}</span>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('change.mode') }}">{{(Auth::user()->mode == 'light') ? __('Light Mode') : __('Dark Mode')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
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

<div id="cModal" class="modal fade conformation" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-2">{{__('Are you sure ?')}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="conf-text">
                        <p>{{__('This action can not be undone. Do you want to continue ?')}}</p>
                    </div>
                    <div class="conform-btn text-right">
                        <button class="btn btn-danger confirm_yes">{{__('Yes')}}</button>
                        <button class="btn btn-defult" data-dismiss="modal">{{__('Cancel')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.admin.footer')

</body>
</html>
