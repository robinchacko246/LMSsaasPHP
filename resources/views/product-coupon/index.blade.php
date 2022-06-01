@extends('layouts.admin')
@section('page-title')
    {{__('Course Coupons')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Course Coupons')}}</h5>
    </div>
@endsection
@section('action-btn')
    <a href="#" data-size="lg" data-url="{{route('product-coupon.create')}}" data-ajax-popup="true" data-title="{{__('Add Coupon')}}" class="btn btn-sm btn-white bor-radius">
        <i class="fa fa-plus"></i> {{ __('Add Coupon') }}
    </a>
    <a href="{{route('product-coupon.export')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-file-excel"></i> {{__('Export')}}
    </a>
    <a href="#" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-url="{{ route('product-coupon.file.import') }}" data-ajax-popup="true" data-title="{{__('Import product-coupon CSV file')}}">
        <i class="fa fa-file-csv"></i> {{__('Import')}}
    </a>
@endsection
@push('script-page')
    <script>
        $(document).on('click', '#code-generate', function () {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="selection-datatable" class="table table-hover" width="100%">
                            <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Code')}}</th>
                                <th> {{__('Discount (%)')}}</th>
                                <th> {{__('Limit')}}</th>
                                <th> {{__('Used')}}</th>
                                <th class="text-right"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            @if(count($productcoupons) > 0 && !empty($productcoupons))
                                <tbody>
                                    @foreach ($productcoupons as $coupon)
                                        <tr class="font-style">
                                            <td>{{ $coupon->name }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            @if($coupon->enable_flat == 'off')
                                                <td>{{ $coupon->discount.'%'}}</td>
                                            @endif
                                            @if($coupon->enable_flat == 'on')
                                                <td>{{ $coupon->flat_discount.' '.('(Flat)')}}</td>
                                            @endif
                                            <td>{{ $coupon->limit }}</td>
                                            <td>{{ $coupon->product_coupon() }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('product-coupon.show',$coupon->id) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Details')}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="action-item" data-size="lg" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Edit Coupon')}}" data-url="{{route('product-coupon.edit',[$coupon->id])}}">
                                                    <i class="fas fa-edit"></i></a>

                                                <a href="#" class="action-item" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$coupon->id}}').submit();">
                                                    <i class="fas fa-trash"></i></a>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product-coupon.destroy', $coupon->id],'id'=>'delete-form-'.$coupon->id]) !!}
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
            </div>
        </div>
    </div>
@endsection
