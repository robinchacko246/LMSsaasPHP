@extends('layouts.admin')
@section('page-title')
    {{__('Course')}}
@endsection
@section('title')
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')
    <a href="{{ route('course.index') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-arrow-left"></i>
    </a>
@endsection
@section('filter')
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('assets/libs/summernote/summernote-bs4.css')}}">
    <style>
        .dropdown-toggle::after {
            content: none;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .margin-r {
            margin-right: 44px;
        }
    </style>
@endpush
@push('script-page')
    <script src="{{asset('assets/libs/summernote/summernote-bs4.js')}}"></script>
    {{--Switch--}}
    <script>
        $(document).ready(function () {
            type();
            $(document).on('click', '.code', function (e) {
                var type = $(this).val();
                if (type == 'Quiz') {
                    $('#quiz-content-1').removeClass('d-none');
                    $('#quiz-content-1').addClass('d-block');

                    $('#course-content-2').removeClass('d-block');
                    $('#course-content-2').addClass('d-none');
                    $('#course-content-3').removeClass('d-block');
                    $('#course-content-3').addClass('d-none');
                    $('#course-content-4').removeClass('d-block');
                    $('#course-content-4').addClass('d-none');

                    $('#subcategory').removeAttr('required');

                } else {
                    $('#course-content-2').removeClass('d-none');
                    $('#course-content-2').addClass('d-block');
                    $('#course-content-3').removeClass('d-none');
                    $('#course-content-3').addClass('d-block');
                    $('#course-content-4').removeClass('d-none');
                    $('#course-content-4').addClass('d-block');

                    $('#subcategory').attr('required');

                    $('#duration').removeClass('col-md-6');
                    $('#duration').addClass('col-md-6');


                    $('#quiz-content-1').removeClass('d-block');
                    $('#quiz-content-1').addClass('d-none');
                }
            });
            $(document).on('click', '#customSwitches', function () {
                if ($(this).is(":checked")) {
                    $('#price').addClass('d-none');
                    $('#price').removeClass('d-block');
                    $('#discount-div').addClass('d-none');
                    $('#discount-div').removeClass('d-block');
                } else {
                    $('#price').addClass('d-block');
                    $('#price').removeClass('d-none');
                    $('#discount-div').addClass('d-block');
                    $('#discount-div').removeClass('d-none');
                }
            });
            $(document).on('click', '#customSwitches2', function () {
                if ($(this).is(":checked")) {
                    $('#discount').addClass('d-block');
                    $('#discount').removeClass('d-none');
                } else {
                    $('#discount').addClass('d-none');
                    $('#discount').removeClass('d-block');
                }
            });

            function type() {
                if ($('#customSwitches3').is(":checked")) {
                    $('#preview_type').addClass('d-block');
                    $('#preview_type').removeClass('d-none');

                    preview();
                } else {
                    $('#preview_type').addClass('d-none');
                    $('#preview_type').removeClass('d-block');

                    $('#preview-iframe-div').addClass('d-none');
                    $('#preview-iframe-div').removeClass('d-block');

                    $('#preview-video-div').addClass('d-none');
                    $('#preview-video-div').removeClass('d-block');

                    $('#preview-image-div').addClass('d-none');
                    $('#preview-image-div').removeClass('d-block');

                }
            }

            $(document).on('click', '#customSwitches3', function () {
                if ($('#customSwitches3').is(":checked")) {
                    $('#preview_type').addClass('d-block');
                    $('#preview_type').removeClass('d-none');

                    preview();
                } else {
                    $('#preview_type').addClass('d-none');
                    $('#preview_type').removeClass('d-block');

                    $('#preview-iframe-div').addClass('d-none');
                    $('#preview-iframe-div').removeClass('d-block');

                    $('#preview-video-div').addClass('d-none');
                    $('#preview-video-div').removeClass('d-block');

                    $('#preview-image-div').addClass('d-none');
                    $('#preview-image-div').removeClass('d-block');

                }
            });

            function preview() {
                $("#preview_type").change(function () {
                    $(this).find("option:selected").each(function () {
                        var optionValue = $(this).attr("value");
                        if (optionValue == 'Image') {

                            $('#preview-image-div').removeClass('d-none');
                            $('#preview-image-div').addClass('d-block');

                            $('#preview-iframe-div').addClass('d-none');
                            $('#preview-iframe-div').removeClass('d-block');

                            $('#preview-video-div').addClass('d-none');
                            $('#preview-video-div').removeClass('d-block');

                        } else if (optionValue == 'iFrame') {

                            $('#preview-image-div').addClass('d-none');
                            $('#preview-image-div').removeClass('d-block');

                            $('#preview-iframe-div').removeClass('d-none');
                            $('#preview-iframe-div').addClass('d-block');

                            $('#preview-video-div').addClass('d-none');
                            $('#preview-video-div').removeClass('d-block');

                        } else if (optionValue == 'Video File') {

                            $('#preview-image-div').addClass('d-none');
                            $('#preview-image-div').removeClass('d-block');

                            $('#preview-iframe-div').addClass('d-none');
                            $('#preview-iframe-div').removeClass('d-block');


                            $('#preview-video-div').removeClass('d-none');
                            $('#preview-video-div').addClass('d-block');
                        }
                    });
                }).change();
            }
        });
    </script>
    {{--Subcategory--}}
    <script>
        function getSubcategory(cid) {
            $.ajax({
                url: '{{route('course.getsubcategory')}}',
                type: 'POST',
                data: {
                    "category_id": cid, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#subcategory').empty();
                    $('#subcategory').append('<option value="" disabled>{{__('Select Subcategory')}}</option>');

                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $course->sub_category }}') {
                            select = 'selected';
                        }
                        $('#subcategory').append('<option value="' + key + '"' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).on('change', '#category_id', function () {
            var category_id = $(this).val();
            getSubcategory(category_id);
        });
    </script>
    {{--Dropzone--}}
    <script>
        var Dropzones = function () {
            var e = $('[data-toggle="dropzone1"]'), t = $(".dz-preview");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            e.length && (Dropzone.autoDiscover = !1, e.each(function () {
                var e, a, n, o, i;
                e = $(this), a = void 0 !== e.data("dropzone-multiple"), n = e.find(t), o = void 0, i = {
                    url: "{{route('course.practicesfiles',[$course_id])}}",
                    headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    previewsContainer: n.get(0),
                    previewTemplate: n.html(),
                    maxFiles: 10,
                    parallelUploads: 10,
                    autoProcessQueue: true,
                    uploadMultiple: true,
                    acceptedFiles: a ? null : "image/*",
                    success: function (file, response) {
                        if (response.status == "success") {
                            show_toastr('success', response.success, 'success');
                            setInterval('location.reload()', 1200);
                        } else {
                            show_toastr('Error', response.msg, 'error');
                        }
                    },
                    error: function (file, response) {
                        if (response.error) {
                            show_toastr('Error', response.error, 'error');
                        } else {
                            show_toastr('Error', response, 'error');
                        }
                    },
                    init: function () {
                        var myDropzone = this;
                    }

                }, n.html(""), e.dropzone(i)
            }))
        }();

        /*FILE DELETE*/
        $(".deleteRecord").click(function () {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
                {
                    url: '{{ route('practices.file.delete', '_id') }}'.replace('_id', id),
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (response) {
                        show_toastr('Success', response.success, 'success');
                        $('.product_Image[data-id="' + response.id + '"]').remove();
                    }, error: function (response) {
                        show_toastr('Error', response.error, 'error');
                    }

                });
        });
    </script>
@endpush
@section('content')
    <!-- Listing -->
    <div class="card">
        <!-- Card header -->
        <ul class="nav nav-tabs nav-overflow profile-tab-list" role="tablist">
            <li class="nav-item ml-4">
                <a href="#headerstab" id="headers_tab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fas fa-align-left mr-2"></i>
                    {{__('Create Content')}}
                </a>
            </li>
            <li class="nav-item ml-4">
                <a href="#coursetab" id="course_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fas fa-edit mr-2"></i>
                    {{__('Edit Course')}}
                </a>
            </li>
            <li class="nav-item ml-4">
                <a href="#practicestab" id="practice_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fas fa-book mr-2"></i>
                    {{__('Practice')}}
                </a>
            </li>
            <li class="nav-item ml-4">
                <a href="#faqstab" id="faqs_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fas fa-question-circle mr-2"></i>
                    {{__('FAQs')}}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            {{--HEADER--}}
            <div class="tab-pane fade show active" id="headerstab" role="tabpanel" aria-labelledby="orders-tab">
                <div class="container py-2">
                    <a href="#" data-size="xl" data-url="{{route('headers.create',$course_id)}}" data-ajax-popup="true" data-title="{{__('Create Header')}}" class="btn btn-primary btn-sm bor-radius " style="margin-left:90%; width:150px;">
                        <i class="fa fa-plus"> {{__('Create Header')}}</i>
                    </a>
                </div>
                <div class="container-fluid">
                    @if(!empty($headers) && count($headers) > 0)
                        @foreach ($headers as $header)
                            <div class="card mt-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <b>{{ $header->title }}</b>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="{{route('chapters.create',[$course_id,$header->id])}}" class="action-item" data-toggle="tooltip" data-title="{{__('Create Chapter')}}">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="#" class="action-item" data-size="xl" data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Edit')}}" data-title="{{__('Edit Header')}}" data-url="{{route('headers.edit',[$header->id,$course_id])}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$header->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['headers.destroy', [$header->id,$course_id]],'id'=>'delete-form-'.$header->id]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($header->chapters_data))
                                    <div class="ml-5 mt-3">
                                        @foreach($header->chapters_data as $chapters)
                                            <p>
                                                <i class="fa fa-play-circle"></i>
                                                <span class="ml-3">{{$chapters->name}}</span>
                                                <a href="#" class="action-item float-right margin-r" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$chapters->id}}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="{{route('chapters.edit',[$course_id,$chapters->id,$header->id])}}" class="action-item float-right mr-1" data-toggle="tooltip" data-title="{{__('Edit Chapter')}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['chapters.destroy', [$chapters->id,$course_id,$header->id]],'id'=>'delete-form-'.$chapters->id]) !!}
                                                {!! Form::close() !!}
                                            </p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <tbody>
                        <tr>
                            <td>
                                <div class="text-center">
                                    <i class="fas fa-folder-open text-primary" style="font-size: 48px;"></i>
                                    <h2>{{__('Opps')}}...</h2>
                                    <h6>{{__('No data Found')}}. </h6>
                                    <h6>{{__('Please Create New Header')}}. </h6>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    @endif
                </div>
            </div>
            {{--EDIT COURSE--}}
            <div class="tab-pane fade show" id="coursetab" role="tabpanel" aria-labelledby="orders-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                {{Form::model($course,array('route' => array('course.update', $course->id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        {{Form::label('title',__('Topic Title'),['class'=>'form-control-label'])}}
                                        {{Form::text('title',null,array('class'=>'form-control font-style','required'=>'required'))}}
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12">
                                        {{Form::label('course_requirements',__('Course Requirements'),['class'=>'form-control-label'])}}
                                        {!! Form::textarea('course_requirements',null,array('class'=>'form-control summernote-simple','rows'=>15,)) !!}
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12">
                                        {{Form::label('course_description',__('Course Description'),['class'=>'form-control-label'])}}
                                        {!! Form::textarea('course_description',null,array('class'=>'form-control summernote-simple','rows'=>15,)) !!}
                                    </div>

                                    <div class="form-group col-md-6 {{ ($course->type == 'Quiz')? '' :'d-none'}} " id="quiz-content-1">
                                        {{Form::label('quiz',__('Select Quiz'),['class'=>'form-control-label'])}}
                                        {!!Form::select('quiz[]', $quiz, explode(',',$course->quiz),array('class' => 'form-control','data-toggle'=>'select','multiple')) !!}
                                    </div>

                                    <div class="form-group col-md-6 {{ ($course->type == 'Course')? '' :'d-none'}}" id="course-content-2">
                                        {{Form::label('category',__('Select Category'),['class'=>'form-control-label'])}}
                                        {!! Form::select('category',$category,null,array('class'=>'form-control','id'=>'category_id')) !!}
                                    </div>
                                    <div class="form-group col-md-6 {{ ($course->type == 'Course')? '' :'d-none'}}" id="course-content-3">
                                        {{Form::label('subcategory',__('Select Subcategory'),['class'=>'form-control-label'])}}
                                        {!!Form::select('subcategory[]', $sub_category, explode(',',$course->sub_category),array('class' => 'form-control','data-toggle'=>'select','multiple','id'=>'subcategory')) !!}

                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('level',__('Select Level'),['class'=>'form-control-label'])}}
                                        {!! Form::select('level',$level,null,array('class'=>'form-control ' )) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('lang',__('Language'),['class'=>'form-control-label'])}}
                                        {{Form::text('lang',null,array('class'=>'form-control font-style','required'=>'required'))}}
                                    </div>
                                    <div class="form-group col-md-6 {{ ($course->type == 'Quiz')? 'd-none' :''}}" id="duration">
                                        {{Form::label('duration',__('Duration'),['class'=>'form-control-label'])}}
                                        {{Form::text('duration',null,array('class'=>'form-control font-style'))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('status',__('Status'),['class'=>'form-control-label'])}}
                                        {!! Form::select('status',$status,null,array('class'=>'form-control ' )) !!}
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="custom-control form-group col-md-5 mt-5 ml-3 custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="is_free" {{ ($course->is_free == 'on')? 'checked' :''}}>
                                                {{Form::label('customSwitches',__('This is free'),['class'=>'custom-control-label form-control-label'])}}
                                            </div>
                                            <div class="form-group col-md-6 ml-auto {{ ($course->is_free == 'on')? 'd-none' :''}}" id="price">
                                                {{Form::label('price',__('Price'),['class'=>'form-control-label'])}}
                                                {{Form::text('price',null,array('class'=>'form-control font-style'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 {{ ($course->is_free == 'on')? 'd-none' :''}}" id="discount-div">
                                        <div class="row">
                                            <div class="custom-control form-group col-md-5 mt-5 ml-3 custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitches2" name="has_discount" {{ ($course->has_discount == 'on')? 'checked' :''}}>
                                                {{Form::label('customSwitches2',__('Discount'),['class'=>'custom-control-label form-control-label'])}}
                                            </div>
                                            <div class="form-group col-md-6 ml-auto {{ ($course->has_discount == 'on')? '' :'d-none'}}" id="discount">
                                                {{Form::label('discount',__('Discount'),['class'=>'form-control-label'])}}
                                                {{Form::text('discount',null,array('class'=>'form-control font-style'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="custom-control form-group col-md-12 mt-5 ml-3 custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitches4" name="featured_course" {{ ($course->featured_course == 'on')? 'checked' :''}}>
                                                {{Form::label('customSwitches4',__('Featured Course'),['class'=>'custom-control-label form-control-label'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="custom-control form-group col-md-5 mt-5 ml-3 custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitches3" name="is_preview" {{ ($course->is_preview == 'on')? 'checked' :''}}>
                                                {{Form::label('customSwitches3',__('Preview'),['class'=>'custom-control-label form-control-label'])}}
                                            </div>
                                            <div class="form-group col-md-6 ml-auto {{ ($course->is_preview == 'on')? '' :'d-none'}}" id="preview_type">
                                                {{Form::label('preview_type',__('Preview Type'),['class'=>'form-control-label'])}}
                                                {{Form::select('preview_type',$preview_type,null,array('class'=>'form-control font-style','id'=>'preview_type'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 mt-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="thumbnail" class="form-control-label">{{ __('Upload thumbnail') }}</label>
                                                <input type="file" name="thumbnail" id="thumbnail" class="custom-input-file">
                                                <label for="thumbnail">
                                                    <i class="fa fa-upload"></i>
                                                    <span>{{__('Choose a image')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6 mt-4 d-none" id="preview-video-div">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="preview_video" class="form-control-label">{{ __('Preview Video') }}</label>
                                                <input type="file" name="preview_video" id="preview_video" class="custom-input-file">
                                                <label for="preview_video">
                                                    <i class="fa fa-upload"></i>
                                                    <span>{{__('Choose a video')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 mt-4 ml-auto d-none" id="preview-iframe-div">
                                        {{Form::label('preview_iframe',__('Preview iFrame'),['class'=>'form-control-label'])}}
                                        <input class="form-control font-style" name="preview_iframe" type="text" id="preview_iframe" value="{{ ($course->preview_type == 'iFrame')? $course->preview_content :''}}">
                                    </div>
                                    <div class="form-group col-lg-6 mt-4 d-none" id="preview-image-div">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="preview_image" class="form-control-label">{{ __('Preview Image') }}</label>
                                                <input type="file" name="preview_image" id="preview_image" class="custom-input-file">
                                                <label for="preview_image">
                                                    <i class="fa fa-upload"></i>
                                                    <span>{{__('Choose a preview image')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 col-lg-12">
                                        {{Form::label('meta_keywords',__('Meta Keywords'),['class'=>'form-control-label'])}}
                                        {!! Form::textarea('meta_keywords',null,array('class'=>'form-control','rows'=>8,)) !!}
                                    </div>

                                    <div class="form-group col-md-12 col-lg-12">
                                        {{Form::label('meta_description',__('Meta Description'),['class'=>'form-control-label'])}}
                                        {!! Form::textarea('meta_description',null,array('class'=>'form-control','rows'=>5,)) !!}
                                    </div>

                                    <div class="w-100 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--PRACTICES--}}
            <div class="tab-pane fade show" id="practicestab" role="tabpanel" aria-labelledby="orders-tab">
                {{Form::open(array('method'=>'post','id'=>'frmTarget','enctype'=>'multipart/form-data'))}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {{Form::label('content',__('Practices Files'),array('class'=>'form-control-label')) }}
                                <div class="dropzone dropzone-multiple" data-toggle="dropzone1" data-dropzone-url="http://" data-dropzone-multiple>
                                    <div class="fallback">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="dropzone-1" name="file" multiple>
                                            <label class="custom-file-label" for="customFileUpload">{{__('Choose file')}}</label>
                                        </div>
                                    </div>
                                    <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar">
                                                        <img class="rounded" src="" alt="Image placeholder" data-dz-thumbnail>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h6 class="text-sm mb-1" data-dz-name>...</h6>
                                                    <p class="small text-muted mb-0" data-dz-size></p>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="dropdown-item" data-dz-remove>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-wrapper lead-common-box">
                                @if(!empty($practices_files) && count($practices_files) > 0)
                                    @foreach($practices_files as $practices_file)
                                        <div class="card mb-3 border shadow-none product_Image" data-id="{{$practices_file->id}}">
                                            <div class="px-3 py-3">
                                                <div class="row align-items-center">
                                                    <div class="col ml-n2">
                                                        <p class="card-text small text-muted">
                                                            {{$practices_file->file_name}}
                                                        </p>
                                                    </div>
                                                    <div class="col-auto actions">
                                                        <a href="#" class="action-item" data-size="xl" data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Edit File Name')}}" data-title="{{__('Edit File Name')}}" data-url="{{route('practices.filename.edit',[$practices_file])}}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-auto actions">
                                                        <a class="action-item" href=" {{asset(Storage::url('uploads/practices/'.$practices_file->files))}}" download="" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-auto actions">
                                                        <a name="deleteRecord" class="action-item deleteRecord" data-id="{{ $practices_file->id }}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tbody>
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center">
                                                <i class="fas fa-folder-open text-primary" style="font-size: 48px;"></i>
                                                <h2>{{__('Opps')}}...</h2>
                                                <h6>{{__('No data Found')}}. </h6>
                                                <h6>{{__('Please Upload Practices Files')}}. </h6>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            {{--FAQS--}}
            <div class="tab-pane fade show" id="faqstab" role="tabpanel" aria-labelledby="orders-tab">
                <div class="card-header">
                    <a href="#" data-size="xl" data-url="{{route('faqs.create',$course_id)}}" data-ajax-popup="true" data-title="{{__('Create FAQs')}}" class="btn btn-primary btn-sm bor-radius " style="margin-left:90%; width:150px;">
                        <i class="fa fa-plus"> {{__('Create FAQs')}}</i>
                    </a>
                </div>
                <div class="card-body">
                    <div id="accordion-2" class="accordion accordion-spaced">
                        @if(count($faqs) > 0 && !empty($faqs))
                            @foreach($faqs as $k_f => $faq)
                                <div class="row">
                                    <div class="col-11">
                                        <div class="card">
                                            <div class="card-header py-4" id="heading-2-2" data-toggle="collapse" role="button" data-target="#collapse-2-{{$k_f}}" aria-expanded="false" aria-controls="collapse-2-2">
                                                <h6 class="mb-0"><i data-feather="unlock" class="mr-3"></i>{{$faq->question}}</h6>
                                            </div>
                                            <div id="collapse-2-{{$k_f}}" class="collapse" aria-labelledby="heading-2-2" data-parent="#accordion-2">
                                                <div class="card-body">
                                                    <p>{{$faq->answer}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <a href="#" class="action-item" data-size="xl" data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Edit')}}" data-title="{{__('Edit')}}" data-url="{{route('faqs.edit',[$faq->id,$course_id])}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$faq->id}}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['faqs.destroy', [$faq->id,$course_id]],'id'=>'delete-form-'.$faq->id]) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tbody>
                            <tr>
                                <td colspan="7">
                                    <div class="text-center">
                                        <i class="fas fa-folder-open text-primary" style="font-size: 48px;"></i>
                                        <h2>{{__('Opps')}}...</h2>
                                        <h6>{{__('No data Found')}}. </h6>
                                        <h6>{{__('Please Create New FAQs')}}. </h6>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
