@extends('layouts.shopfront')
@section('page-title')
    {{__('Home')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
    <script src="{{asset('assets/js/bootstrap.bundle.min.5.0.1.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/moovie.css')}}">
@endpush
@push('script-page')
    <script src="{{asset('assets/js/moovie.js')}}"></script>
    <script>
        $(document).on('click', '.topic', function (e) {
            var id = $(this).attr('id');
            collapse(id);
        });

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

        $(document).on('click', '.checkbox', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-value');
            var aa = $(this);
            if ($(this).prop("checked") == false) {
                $.ajax({
                    type: "POST",
                    url: '{{route('student.remove.checkbox',[ '__chapter_id',$course_id,$slug])}}'.replace('__chapter_id', id),
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status == "Success") {
                            show_toastr('Success', response.success, 'success');
                            $(aa).prop("checked", false);
                            $('#progress_percent').html('');
                            $('#progress_percent').html(response.progress + '%');
                            $("#green_progress").css("width", response.progress + "%");
                        } else {
                            show_toastr('Error', response.error, 'error');
                        }

                        if (response.progress < 100) {
                            $(".certificate_btn").addClass('d-none');
                            $(".btn_certi").addClass('d-none');
                        } else {
                            $(".certificate_btn").removeClass('d-none');
                        }

                    },
                    error: function (result) {
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{route('student.checkbox', ['__chapter_id',$course_id,$slug])}}'.replace('__chapter_id', id),
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status == "Success") {
                            show_toastr('Success', response.success, 'success');
                            $(aa).prop("checked", true);
                            $('#progress_percent').html('');
                            $('#progress_percent').html(response.progress + '%');
                            $("#green_progress").css("width", response.progress + "%");
                        } else {
                            show_toastr('Error', response.error, 'error');
                        }

                        if (response.progress < 100) {
                            $(".certificate_btn").addClass('d-none');
                            $(".btn_certi").addClass('d-none');
                        } else {
                            $(".certificate_btn").removeClass('d-none');
                        }

                    },
                    error: function (result) {
                    }
                });
            }
        });

        function collapse(id) {
            var collpase_id = "collapseExample-" + id;
            document.getElementById(collpase_id).classList.toggle("show");
        }

        function myFunction() {
            document.getElementById("fullscreenDropdown").classList.toggle("show");
            document.getElementById("fullscreenContent").classList.toggle("hide");
        }

        $(document).on('click', '.show-hidden-menu', function (e) {
            $('#' + $(this).attr('data-id') + '_hidden_menu').slideToggle("slow");
        });
    </script>
@endpush
@section('content')
    @php
        $userstore = \App\Models\UserStore::where('store_id', $store->id)->first();
        $settings  =\DB::table('settings')->where('name','company_favicon')->where('created_by', $userstore->user_id)->first();
        $i = 0;
    @endphp
    <div class="chapter_heading">
        <div class="container-lg">
            <div class="row">
                <div class="col col-lg-12">
                    <div class="chapter_heading_sub">
                        <div class="course-back">
                            <a href="{{route('store.viewcourse',[$slug,\Illuminate\Support\Facades\Crypt::encrypt($course_id)])}}">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                {{__('Back')}}
                            </a>
                        </div>
                        <div class="course-name-main">
                            <h4>{{__('Chapter')}} <span>{{$current_chapter->name}}</span></h4>
                        </div>
                        <div class="course-progress">
                            <div class="progress-label d-flex align-items-center justify-content-between">
                                <p class="m-0"> {{__('Progress')}} </p>
                                <span id="progress_percent"> {{!empty($progress)?$progress.'%':'0%'}} </span>
                            </div>
                            <div class="progress rounded-pill m-0">
                                <div class="progress-bar rounded-pill" id="green_progress" role="progressbar" style="width: {{!empty($progress)?$progress:'0'}}%;" aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- download button --}}
                        <div class="download_prev_btn">
                            @if(count($cs_incomplete) == 0)
                                <div class="download_btn">
                                    <a href="{{ route('certificate.pdf', Crypt::encrypt($store->certificate_template))}}" target="_blank" class="btn btn-sm btn-primary rounded-pill mr-auto btn_certi certificate_dl">{{__('Download')}}</a>
                                </div>
                            @elseif(count($cs_incomplete) == 1)
                                <div class="download_btn">
                                    <a href="{{ route('certificate.pdf', Crypt::encrypt($store->certificate_template))}}" target="_blank" class="btn btn-sm btn-primary rounded-pill mr-auto d-none">{{__('Download')}}</a>
                                </div>
                            @endif
                            <div class="download_btn d-none">
                                <div class="certificate_btn ">
                                    <a href="{{ route('certificate.pdf', Crypt::encrypt($store->certificate_template)) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-primary rounded-pill mr-auto">{{ __('Download') }}</a>
                                </div>
                            </div>

                            <div class="course-previous-next-btn d-flex align-items-center">
                                @if($current_chapter->id != $last_previous)
                                    <a href="{{route('store.fullscreen',[$slug,\Illuminate\Support\Facades\Crypt::encrypt($course_id),\Illuminate\Support\Facades\Crypt::encrypt($current_chapter->id),'previous'])}}" class="course-previous-btn d-flex align-items-center">
                                        <img src="{{asset('assets/img/previous-light.svg')}}" alt="previous-light" class="img-fluid hover-hide">
                                        <img src="{{asset('assets/img/previous-color.svg')}}" alt="previous-light" class="img-fluid hover-show">
                                        <p>{{__('Previous Chapter')}} <span> </span></p>
                                    </a>
                                @else
                                    <a class="course-previous-btn d-flex align-items-center disabled">
                                        <img src="{{asset('assets/img/previous-light.svg')}}" alt="previous-light" class="img-fluid hover-hide">
                                        <img src="{{asset('assets/img/previous-color.svg')}}" alt="previous-light" class="img-fluid hover-show">
                                        <p>{{__('Previous Chapter')}} <span> </span></p>
                                    </a>
                                @endif
                                <div class="line"></div>
                                @if($current_chapter->id != $last_next->id)
                                    <a class="course-next-btn d-flex align-items-center" href="{{route('store.fullscreen',[$slug,\Illuminate\Support\Facades\Crypt::encrypt($course_id),\Illuminate\Support\Facades\Crypt::encrypt($current_chapter->id),'next'])}}">
                                        <p>{{__('Next Chapter')}}</p>
                                        <img src="{{asset('assets/img/next-light.svg')}}" alt="next-light" class="img-fluid hover-hide">
                                        <img src="{{asset('assets/img/next-color.svg')}}" alt="next-light" class="img-fluid hover-show">
                                    </a>
                                @else
                                    <a class="course-next-btn d-flex align-items-center disabled">
                                        <p>{{__('Next Chapter')}}</p>
                                        <img src="{{asset('assets/img/next-light.svg')}}" alt="next-light" class="img-fluid hover-hide">
                                        <img src="{{asset('assets/img/next-color.svg')}}" alt="next-light" class="img-fluid hover-show">
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="course-second chapter-original-video">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="course-video">
                        <div class="course-video-main">
                            @if($current_chapter->type == 'Video File')
                                <video id="example" class="preview_video" height="500" poster="{{asset('assets/img/video-img.png')}}">
                                    <source src="{{asset(Storage::url('uploads/chapters/'.$current_chapter->video_file))}}" type="video/mp4">
                                    {{__('Your browser does not support the video tag.')}}
                                </video>
                            @elseif($current_chapter->type == 'iFrame')
                                @php
                                    if(strpos($current_chapter->iframe, 'src') !== false)
                                    {
                                        preg_match('/src="([^"]+)"/', $current_chapter->iframe, $match);
                                        $url = $match[1];
                                        $iframe_url = str_replace('https://www.youtube.com/embed/','',$url);
                                    }
                                    else
                                    {
                                        $iframe_url = str_replace('https://youtu.be/','', str_replace('https://www.youtube.com/watch?v=','' ,$current_chapter->iframe));
                                    }
                                @endphp
                                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/{{$iframe_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @elseif($current_chapter->type == 'Text Content')
                                <article class="ml-5 mt-5">
                                    {!! $current_chapter->text_content !!}
                                </article>
                            @elseif($current_chapter->type == 'Video Url')
                                @php
                                    if(strpos($current_chapter->video_url, 'src') !== false)
                                    {
                                        preg_match('/src="([^"]+)"/', $current_chapter->video_url, $match);
                                        $url = $match[1];
                                        $video_url = str_replace('https://www.youtube.com/embed/','',$url);
                                    }
                                    else
                                    {
                                        $video_url = str_replace('https://youtu.be/','', str_replace('https://www.youtube.com/watch?v=','' ,$current_chapter->video_url));
                                    }
                                @endphp
                                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/{{$video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>
                    <div class="course-tab">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs d-flex align-items-center" id="myTabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#overview" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                        <img src="{{asset('assets/img/overview.svg')}}" alt="overview" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/unselect-overview.svg')}}" alt="overview" class="img-fluid unselect-tab-img">
                                        {{__('Overview')}}
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#profile" role="tab" data-toggle="tab" aria-controls="profile">
                                        <img src="{{asset('assets/img/syllabus.svg')}}" alt="syllabus" class="img-fluid select-tab-img">
                                        <img src="{{asset('assets/img/syllabus-unselect.svg')}}" alt="syllabus" class="img-fluid unselect-tab-img">Syllabus
                                    </a>
                                </li>
                                <li class="nav-underline" role="presentation"></li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in active" role="tabpanel" id="overview" aria-labelledby="overview">
                                    <h2>
                                        {{$courses->title}}: <br>
                                        {{$current_chapter->name}}
                                    </h2>
                                    <p class="paragraph">
                                        {!! $current_chapter->chapter_description!!}
                                    </p>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab">
                                    <div class="accordian-tab">
                                        <div class="accordion" id="accordionExample">
                                            @foreach($headers as $key => $header)
                                                <div class="accordion-item mb-4">
                                                    <div class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ChapterOne{{$key}}" aria-expanded="true" aria-controls="ChapterOne">
                                                            <p>
                                                                {{$header->title}}
                                                            </p>
                                                        </button>
                                                    </div>
                                                    @foreach($header->chapters_data as $k => $chapters)
                                                        <div id="ChapterOne{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p class="paragraph">
                                                                    {!!$chapters->chapter_description!!}
                                                                </p>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="accordian-tab">
                        <div class="accordion" id="ChapterDetails">
                            @foreach($headers as $key => $header)
                                <div class="accordion-item mb-4">
                                    <div class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#ChapterDetails{{$key}}" aria-expanded="true"
                                                aria-controls="ChapterDetailsOne">
                                            <p>{{$header->title}}</p>
                                        </button>
                                    </div>
                                    <div id="ChapterDetails{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#ChapterDetails">
                                        <div class="accordion-body p-4 pb-0">
                                            <div class="mb-4">
                                                <div class="category-checkbox">
                                                    @foreach($header->chapters_data as $k => $chapters)
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <div class="chapter-description-checkbox d-flex">
                                                            <div class="form-group">
                                                                @if(isset($chapters['chapters_status']) && $chapters['chapters_status']['status'] == 'Active')
                                                                    <input type="checkbox" class="description{{$i}} checkbox" id="description{{$i}}" data-value="{{$chapters->id}}" checked>
                                                                @else
                                                                    <input type="checkbox" class="description{{$i}} checkbox" id="description{{$i}}" data-value="{{$chapters->id}}">
                                                                @endif
                                                                <label for="description{{$i}}"></label>
                                                            </div>
                                                            <div data-id="{{$chapters->id}}" class="chapter-description-text h-30 w-100 show-hidden-menu d-flex align-items-center justify-content-between">
                                                                <div class="form-group">
                                                                    <label for="description{{$i}}">{{$i.'. '.$chapters->name}}</label>
                                                                </div>
                                                                <div class="form-group course-time">
                                                                    <span class="">[{{$chapters->duration}}]</span>
                                                                    <a href="{{route('store.fullscreen',[$slug,\Illuminate\Support\Facades\Crypt::encrypt($course_id),\Illuminate\Support\Facades\Crypt::encrypt($chapters->id) ])}}">
                                                                        <img src="{{asset('assets/img/done.svg')}}" alt="done" class="img-fluid">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="hidden-menu" id="{{$chapters->id}}_hidden_menu" style="display: none;">
                                                            {!!$chapters->text_content!!}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($practices_files->count()>0)
                                <div class="accordion-item mb-4">
                                    <div class="accordion-header">
                                        <div class="project-file">
                                            <p>
                                                <img src="{{asset('assets/img/project-files.svg')}}" alt="project" class="img-fluid">
                                                {{__('project-file')}}</p>
                                        </div>
                                    </div>
                                    @foreach($practices_files as $practices_file)
                                        <div class="project-body p-4 pb-2" data-id="{{$practices_file->id}}">
                                            <div class="project-border">
                                                <div class="project-file-main d-flex align-items-center">
                                                    <div class="project-file-image">
                                                        <a class="action-item" href="{{asset(Storage::url('uploads/practices/'.$practices_file->files))}}">
                                                            <img src="{{asset('assets/img/ai.svg')}}" alt="ai" class="img-fluid">
                                                        </a>
                                                    </div>
                                                    <div class="project-file-name w-100 d-flex align-items-center justify-content-between">
                                                        <div class="project-file-name-main">
                                                            <a class="action-item" href="{{asset(Storage::url('uploads/practices/'.$practices_file->files))}}">
                                                                <h5>{{$practices_file->file_name}}</h5>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
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
