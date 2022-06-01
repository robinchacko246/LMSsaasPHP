@extends('layouts.admin')
@section('page-title')
    {{__('Subcategory')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Subcategory')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')
    <a href="#" data-size="lg" data-url="{{route('subcategory.create')}}" data-ajax-popup="true" data-title="{{__('Add Subcategory')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
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
                    <h6 class="d-inline-block mb-0">{{__('All Subcategories')}}</h6>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col">{{ __('Name')}}</th>
                    <th scope="col">{{ __('Category')}}</th>
                    <th scope="col">{{ __('Created at')}}</th>
                    <th scope="col" class="text-right">{{ __('Action')}}</th>
                </tr>
                </thead>
                @if(count($subcategorise) > 0 &&  !empty($subcategorise))
                    <tbody class="list">
                    @foreach ($subcategorise as $subcategory)
                        <tr>
                            <td>{{ $subcategory->name }}</td>
                            <td>{{!empty($subcategory->category_id->name)?$subcategory->category_id->name:''}}</td>
                            <td> {{ Utility::dateFormat($subcategory->created_at)}}</td>
                            <td class="text-right">
                                <a href="#" class="action-item" data-size="lg" data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Edit')}}" data-title="{{__('Edit Category')}}" data-url="{{route('subcategory.edit',[$subcategory->id])}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$subcategory->id}}').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['subcategory.destroy', $subcategory->id],'id'=>'delete-form-'.$subcategory->id]) !!}
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

