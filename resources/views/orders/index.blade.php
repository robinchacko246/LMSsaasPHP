@extends('layouts.admin')
@section('page-title')
    {{__('Order')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h5 d-inline-block text-white font-weight-bold mb-0 ">{{__('Orders ')}}</h5>
    </div>
@endsection
@section('action-btn')
    <a href="{{route('order.export')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle">
        <i class="fa fa-file-excel"></i> {{__('Export')}}
    </a>
@endsection
@section('filter')
@endsection
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col">{{__('Order')}}</th>
                    <th scope="col" class="sort">{{__('Date')}}</th>
                    <th scope="col" class="sort">{{__('Name')}}</th>
                    <th scope="col" class="sort">{{__('Value')}}</th>
                    <th scope="col" class="sort">{{__('Payment Type')}}</th>
                    <th scope="col" class="text-right">{{__('Action')}}</th>
                </tr>
                </thead>
                @if(!empty($orders) && count($orders) > 0)
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th scope="row">
                                <a href="{{route('orders.show',$order->id)}}" class="btn btn-sm btn-white btn-icon rounded-pill text-dark">
                                    <span class="btn-inner--text">{{$order->order_id}}</span>
                                </a>
                            </th>
                            <td class="order">
                                <span class="h6 text-sm font-weight-bold mb-0">{{ Utility::dateFormat($order->created_at)}}</span>
                            </td>
                            <td>
                                <span class="client">{{$order->name}}</span>
                            </td>
                            <td>
                                <span class="value text-sm mb-0">{{ Utility::priceFormat($order->price)}}</span>
                            </td>
                            <td>
                                <span class="taxes text-sm mb-0">{{$order->payment_type}}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-end">
                                    <!-- Actions -->
                                    <div class="actions ml-3">
                                        <a href="{{route('orders.show',$order->id)}}" class="action-item mr-2" data-toggle="tooltip" data-title="{{__('Details')}}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="action-item mr-2 " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$order->id}}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['orders.destroy', $order->id],'id'=>'delete-form-'.$order->id]) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
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
