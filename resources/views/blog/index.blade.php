@php( $store_logo=asset(Storage::url('uploads/store_logo/')))
@extends('layouts.admin')
@section('page-title')
    {{__('Blog')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Blog')}}</h5>
    </div>
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('assets/libs/summernote/summernote-bs4.css')}}">
@endpush
@push('script-page')
    <script src="{{asset('assets/libs/summernote/summernote-bs4.js')}}"></script>
@endpush
@section('action-btn')
    <a href="#" data-size="lg" data-url="{{ route('blog.social') }}" data-ajax-popup="true" data-title="{{__('Manage Social Blog Button')}}" class="btn btn-sm btn-white bor-radius">
        {{__('Social Media')}}
    </a>
    <a href="#" data-size="lg" data-url="{{ route('blog.create') }}" data-ajax-popup="true" data-title="{{__('Create New Blog')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-plus"></i>
    </a>
@endsection
@section('filter')
@endsection
@section('content')
    <div class="card">
        <!-- Table -->
        <div class="table-responsive">
            <div class="employee_menu view_employee">
                <div class="card-header actions-toolbar border-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h6 class="d-inline-block mb-0 text-capitalize">{{__('All Blogs')}}</h6>
                        </div>
                        <div class="col text-right">
                            <div class="actions">
                                <div class="rounded-pill d-inline-block search_round">
                                    <div class="input-group input-group-sm input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="user_keyword" class="form-control form-control-flush search-user" placeholder="{{__('Search Blog')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-items-center employee_tableese">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">{{__('Blog Cover Image')}}</th>
                            <th scope="col" class="sort" data-sort="name">{{__('Title')}}</th>
                            <th scope="col" class="sort" data-sort="name">{{__('Created At')}}</th>
                            <th class="text-right">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        @if(!empty($blogs) && count($blogs) >0)
                            <tbody>
                            @foreach($blogs as $blog)
                                <tr data-name="{{$blog->title}}">
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div>
                                                <img alt="Image placeholder" src="{{$store_logo}}/{{$blog->blog_cover_image}}" class="rounded-circle" style="width: 80px; height: 60px;">
                                            </div>
                                        </div>
                                    </th>
                                    </td>
                                    <td class="sorting_1">{{$blog->title}}</td>
                                    <td class="sorting_1">{{Utility::dateFormat($blog->created_at)}}</td>
                                    <td class="action text-right">
                                        <a href="#" data-size="lg" data-url="{{ route('blog.edit',$blog->id) }}" data-ajax-popup="true" data-title="{{__('Edit Blog')}}" class="action-item">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$blog->id}}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id],'id'=>'delete-form-'.$blog->id]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    <script>
        $(document).ready(function () {
            $(document).on('keyup', '.search-user', function () {
                var value = $(this).val();
                $('.employee_tableese tbody>tr').each(function (index) {
                    var name = $(this).attr('data-name');
                    if (name.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endpush

