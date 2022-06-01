@extends('layouts.admin')
@section('page-title')
    {{__('Chapters')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Edit Chapter')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')
    <a href="{{route('course.edit',$course_id)}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-arrow-left"></i>
    </a>
@endsection
@section('filter')
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('assets/libs/summernote/summernote-bs4.css')}}">
@endpush
@push('script-page')
    <script src="{{asset('assets/libs/summernote/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#type").change(function(){
                $(this).find("option:selected").each(function(){
                    var optionValue = $(this).attr("value");
                    if(optionValue == 'Video Url')
                    {

                        $('#video_url_div').removeClass('d-none');
                        $('#video_url_div').addClass('d-block');

                        $('#duration_div').removeClass('d-none');
                        $('#duration_div').addClass('d-block');

                        $('#iframe_div').addClass('d-none');
                        $('#iframe_div').removeClass('d-block');

                        $('#text_content_div').addClass('d-none');
                        $('#text_content_div').removeClass('d-block');

                        $('#video_file_div').addClass('d-none');
                        $('#video_file_div').removeClass('d-block');

                    }
                    else if(optionValue == 'iFrame')
                    {
                        $('#video_url_div').addClass('d-none');
                        $('#video_url_div').removeClass('d-block');

                        $('#duration_div').removeClass('d-none');
                        $('#duration_div').addClass('d-block');

                        $('#iframe_div').removeClass('d-none');
                        $('#iframe_div').addClass('d-block');

                        $('#text_content_div').addClass('d-none');
                        $('#text_content_div').removeClass('d-block');

                        $('#video_file_div').addClass('d-none');
                        $('#video_file_div').removeClass('d-block');

                    }
                    else if(optionValue == 'Text Content')
                    {

                        $('#video_url_div').addClass('d-none');
                        $('#video_url_div').removeClass('d-block');

                        $('#duration_div').removeClass('d-block');
                        $('#duration_div').addClass('d-none');

                        $('#iframe_div').addClass('d-none');
                        $('#iframe_div').removeClass('d-block');

                        $('#text_content_div').removeClass('d-none');
                        $('#text_content_div').addClass('d-block');

                        $('#video_file_div').addClass('d-none');
                        $('#video_file_div').removeClass('d-block');
                    }
                    else if(optionValue == 'Video File')
                    {

                        $('#video_url_div').addClass('d-none');
                        $('#video_url_div').removeClass('d-block');

                        $('#duration_div').removeClass('d-none');
                        $('#duration_div').addClass('d-block');

                        $('#iframe_div').addClass('d-none');
                        $('#iframe_div').removeClass('d-block');

                        $('#text_content_div').addClass('d-none');
                        $('#text_content_div').removeClass('d-block');

                        $('#video_file_div').removeClass('d-none');
                        $('#video_file_div').addClass('d-block');
                    }
                });
            }).change();
        });
    </script>
    <script>
        var Dropzones = function () {
            var e = $('[data-toggle="dropzone1"]'), t = $(".dz-preview");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            e.length && (Dropzone.autoDiscover = !1, e.each(function () {
                var e, a, n, o, i;
                e = $(this), a = void 0 !== e.data("dropzone-multiple"), n = e.find(t), o = void 0, i = {
                    url: "{{route('chapters.update',$chapters->id)}}",
                    headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    previewsContainer: n.get(0),
                    previewTemplate: n.html(),
                    maxFiles: 10,
                    parallelUploads: 10,
                    autoProcessQueue: false,
                    uploadMultiple: true,
                    acceptedFiles: a ? null : "image/*",
                    success: function (file, response) {
                        if (response.flag == "success") {
                            show_toastr('success', response.msg, 'success');
                            setInterval('location.reload()', 1500);
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

                        this.on("addedfile", function (e) {
                            !a && o && this.removeFile(o), o = e
                        })
                    }
                }, n.html(""), e.dropzone(i)
            }))
        }();
        $(document).on('click','#submit-all',function(){
            var fd = new FormData();
            var file = document.getElementById('video_file').files[0];
            if (file) {
                fd.append('video_file', file);
            }
            var files = $('[data-toggle="dropzone1"]').get(0).dropzone.getAcceptedFiles();

            $.each(files, function (key, file) {
                fd.append('multiple_files[' + key + ']', $('[data-toggle="dropzone1"]')[0].dropzone.getAcceptedFiles()[key]); // attach dropzone image element
            });
            var other_data = $('#frmTarget').serializeArray();

            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });

            $.ajax({
                url: "{{route('chapters.update',$chapters->id)}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data.flag == "success") {
                        show_toastr('success', data.msg, 'success');
                        setInterval('location.reload()',1500);
                    } else {
                        show_toastr('Error', data.msg, 'error');
                    }
                },
                error: function (data) {

                    if (data.error) {
                        show_toastr('Error', data.error, 'error');
                    } else {
                        show_toastr('Error', data, 'error');
                    }
                },
            });
        });
        $(".deleteRecord").click(function () {

            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
                {
                    url: '{{ route('chapters.file.delete', '_id') }}'.replace('_id', id),
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (response) {
                        show_toastr('Success', response.success, 'success');
                        $('.product_Image[data-id="' + response.id + '"]').remove();
                    },error: function (response) {
                        show_toastr('Error', response.error, 'error');
                    }

                });
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="account_edit" class="tabs-card">
                <div class="card ">
                    <div class="card-body">
                        {{Form::model($chapters,array('id'=>'frmTarget','enctype'=>'multipart/form-data')) }}
                        <div class="row">
                            <div class="form-group col-md-12">
                                {{Form::label('name',__('Chapter Name'),['class'=>'form-control-label'])}}
                                {{Form::text('name',null,array('class'=>'form-control font-style','required'=>'required'))}}
                            </div>
                            <div class="form-group col-md-12 col-lg-12">
                                {{Form::label('chapter_description',__('Chapter Description'),['class'=>'form-control-label'])}}
                                {{Form::textarea('chapter_description',null,array('class'=>'summernote-simple form-control font-style','id'=>'exampleFormControlTextarea1','required'=>'required'))}}
                            </div>
                            <div class="form-group col-md-6">
                                {{Form::label('type',__('Chapter Type'),['class'=>'form-control-label'])}}
                                {!! Form::select('type',$chapter_type,null,array('class'=>'form-control','id'=>'type')) !!}
                            </div>
                            <div class="form-group col-md-6" id="video_url_div">
                                {{Form::label('video_url',__('Video URL'),['class'=>'form-control-label'])}}
                                {{Form::text('video_url',null,array('class'=>'form-control font-style'))}}
                            </div>
                            <div class="form-group col-lg-6" id="video_file_div">
                                <div class="form-group">
                                    <div class="col-12 field mt-2" data-name="attachments">
                                        <div class="attachment-upload">
                                            <div class="attachment-button">
                                                <div class="pull-left">
                                                    <input type="file" name="video_file" id="video_file" class="form-control">
                                                </div>
                                            </div>
                                            <div class="attachments"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6" id="iframe_div">
                                {{Form::label('iframe',__('iFrame'),['class'=>'form-control-label'])}}
                                {{Form::text('iframe',null,array('class'=>'form-control font-style'))}}
                            </div>
                            <div class="form-group col-md-6 mt-4" id="duration_div">
                                {{Form::label('duration',__('Duration'),['class'=>'form-control-label'])}}
                                {{Form::text('duration',null,array('class'=>'form-control font-style'))}}
                            </div>
                            <div class="form-group col-md-12 col-lg-12 mt-4" id="text_content_div">
                                {{Form::label('text_content',__('Text Content'),['class'=>'form-control-label'])}}
                                {!! Form::textarea('text_content',null,array('class'=>'form-control summernote-simple','rows'=>15,)) !!}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{Form::label('content',__('External File'),array('class'=>'form-control-label')) }}
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
                                        <div class="card-wrapper p-3 lead-common-box">
                                            @foreach($file as $files)
                                                <div class="card mb-3 border shadow-none product_Image" data-id="{{$files->id}}">
                                                    <div class="px-3 py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col ml-n2">
                                                                <p class="card-text small text-muted">
                                                                    <img class="rounded" src=" {{asset(Storage::url('uploads/chapters/'.$files->chapter_files))}}" width="70px" alt="Image placeholder" data-dz-thumbnail>
                                                                </p>
                                                            </div>
                                                            <div class="col-auto actions">
                                                                <a class="action-item" href=" {{asset(Storage::url('uploads/chapters/'.$files->chapter_files))}}" download="" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </div>
                                                            <div class="col-auto actions">
                                                                <a name="deleteRecord" class="action-item deleteRecord" data-id="{{ $files->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
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
                        <div class="w-100 text-right">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection


