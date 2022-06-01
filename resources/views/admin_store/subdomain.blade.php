@extends('layouts.admin')
@section('page-title')
    {{__('Sub Domain')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Domain')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('action-btn')
    <a href="{{ route('store.customDomain') }}" class="btn btn-sm btn-white bor-radius">
        {{__('Custom Domain')}}
    </a>
    <a href="{{ route('store.grid') }}" data-title="{{__('Create New Store')}}" class="btn btn-sm btn-white bor-radius">
        {{__('Grid View')}}
    </a>
    <a href="{{ route('store-resource.index') }}" class="btn btn-sm btn-white bor-radius">
        {{__('List View')}}
    </a>
    <a href="#" data-size="lg" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{__('Create New Store')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-plus"></i>
    </a>
@endsection
@section('filter')
@endsection
@push('css-page')
@endpush
@section('content')
    <!-- Listing -->
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col">{{ __('Custom Domain Name')}}</th>
                    <th scope="col">{{ __('Store Name')}}</th>
                    <th scope="col">{{ __('Email')}}</th>

                </tr>
                </thead>
                <tbody class="list">
                    @if(count($stores) > 0)
                        @foreach($stores as $store)
                            <tr>
                                <td>
                                    {{$store->subdomain}}
                                </td>
                                <td>
                                    {{$store->name}}
                                </td>
                                <td>
                                    {{($store->email)}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="font-style">
                            <td colspan="6" class="text-center"><h6 class="text-center">{{__('No Domain Found.')}}</h6></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
