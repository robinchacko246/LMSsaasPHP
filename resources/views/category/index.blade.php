@extends('layouts.admin')
@section('page-title')
    {{__('Category')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Categories')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')
    <a href="#" data-size="lg" data-url="{{route('category.create')}}" data-ajax-popup="true" data-title="{{__('Add Category')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-plus"></i>
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
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <h6 class="d-inline-block mb-0">{{__('All Categories')}}</h6>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col">{{ __('Image')}}</th>
                    <th scope="col">{{ __('Name')}}</th>
                    <th scope="col">{{ __('Created at')}}</th>
                    <th scope="col" class="text-right">{{ __('Action')}}</th>
                </tr>
                </thead>
                @if(count($categorise) > 0 && !empty($categorise))
                    <tbody class="list">
                    @foreach ($categorise as $category)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div>
                                        @if(!empty($category->category_image))
                                            <img alt="Image placeholder" src="{{asset(Storage::url('uploads/category_image/'.$category->category_image))}}" class="" style="width: 80px;">
                                        @else
                                            <img alt="Image placeholder" src="{{asset(Storage::url('uploads/category_image/default.png'))}}" class="" style="width: 80px;">
                                        @endif
                                    </div>
                                </div>
                            </th>
                            <td>{{ $category->name }}</td>
                            <td> {{ Utility::dateFormat($category->created_at)}}</td>
                            <td class="text-right">
                                <a href="#" class="action-item" data-size="lg" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Edit Category')}}" data-original-title="{{__('Edit')}}" data-url="{{route('category.edit',[$category->id])}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$category->id}}').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['category.destroy', $category->id],'id'=>'delete-form-'.$category->id]) !!}
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
                            </div>
                        </td>
                    </tr>
                    </tbody>
                @endif

            </table>
        </div>
    </div>
@endsection
