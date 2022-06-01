@extends('layouts.admin')
@section('page-title')
    {{__('Course')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Courses')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')

    <a href="{{ route('course.create') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-plus"></i>
    </a>

    <a href="{{route('course.export')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-file-excel"></i> {{__('Export')}}
    </a>
    
@endsection
@section('filter')
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('assets/libs/summernote/summernote-bs4.css')}}">
@endpush
@push('script-page')
    <script src="{{asset('assets/libs/summernote/summernote-bs4.js')}}"></script>
@endpush
@section('content')
    <!-- Listing -->
    <div class="card">
        <!-- Card header -->
        <div class="card-header actions-toolbar">
            <div class="actions-search" id="actions-search">
                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent"><i class="far fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-flush" placeholder="Type and hit enter ...">
                    <div class="input-group-append">
                        <a href="#" class="input-group-text bg-transparent" data-action="search-close" data-target="#actions-search"><i class="far fa-times"></i></a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <h6 class="d-inline-block mb-0">{{__('All Courses')}}</h6>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col">{{ __('Thumbnail')}}</th>
                    <th scope="col">{{ __('Type')}}</th>
                    <th scope="col">{{ __('Title')}}</th>
                    <th scope="col">{{ __('Category')}}</th>
                    <th scope="col">{{ __('Status')}}</th>
                    <th scope="col">{{ __('Chapters')}}</th>
                    <th scope="col">{{ __('Enrolled')}}</th>
                    <th scope="col">{{ __('Price')}}</th>
                    <th scope="col">{{ __('Created at')}}</th>
                    <th scope="col" class="text-right">{{ __('Action')}}</th>
                </tr>
                </thead>
                @if(!empty($courses) && count($courses) > 0)
                    <tbody class="list">
                    @foreach($courses as $course)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div>
                                        @if(!empty($course->thumbnail))
                                            <img alt="Image placeholder" src="{{asset(Storage::url('uploads/thumbnail/'.$course->thumbnail))}}" class="" style="width: 80px;">
                                        @else
                                            <img alt="Image placeholder" src="{{asset(Storage::url('uploads/is_cover_image/default.jpg'))}}" class="" style="width: 80px;">
                                        @endif
                                    </div>
                                </div>
                            </th>
                            <td>{{$course->type}}</td>
                            <td>{{$course->title}}</td>
                            <td>{{!empty($course->category_id)?$course->category_id->name:'-'}}</td>
                            <td>{{$course->status}}</td>
                            <td>{{!empty($course->chapter_count)?$course->chapter_count->count():'0'}}</td>
                            <td>{{$course->student_count->count()}}</td>
                            <td>{{ ($course->is_free == 'on')? 'Free' : $course->price}}</td>
                            <td>{{ Utility::dateFormat( $course->created_at)}}</td>
                            <td class="text-right">
                                <!-- Actions -->
                                <div class="actions">
                                    <a href="{{route('course.edit',\Illuminate\Support\Facades\Crypt::encrypt($course->id))}}" class="action-item mr-2" data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="action-item  mr-2 " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$course->id}}').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['course.destroy', $course->id],'id'=>'delete-form-'.$course->id]) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td colspan="10">
                            <div class="text-center">
                                <i class="fas fa-folder-open text-primary" style="font-size: 48px;"></i>
                                <h2>{{__('Opps')}}...</h2>
                                <h6>{{__('No data Found')}}. </h6>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection

