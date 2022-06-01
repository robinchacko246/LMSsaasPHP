
@extends('layouts.admin')
@section('page-title')
    {{__('Zoom Meeting')}}
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}">
@endpush
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{__('Zoom Meeting')}}</h5>
    </div>
@endsection
@section('action-btn')
        <a href="{{ route('zoom-meeting.calender') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1 shadow-sm">
            <i class="far fa-calendar-alt"></i>
        </a>

        @if(\Auth::user()->type == 'Owner')
            <a class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1 shadow-sm" id="add-user" data-size="lg" data-ajax-popup="true"   data-title="{{ __('Create Meeting') }}" data-url="{{route('zoom-meeting.create')}}"> <i class="fas fa-plus"></i> </a>
        @endif
@endsection
@section('content')

    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center dataTable">
                <thead>
                <tr>
                    <th> {{ __('TITLE') }} </th>
                    @if(\Auth::user()->type == 'Owner')
                    <th> {{ __('COURSE') }}  </th>
                    <th> {{ __('STUDENT') }}  </th>
                    @endif
                    <th> {{ __('MEETING TIME') }} </th>
                    <th> {{ __('DURATION') }} </th>
                    <th> {{ __('JOIN URL') }} </th>
                    <th> {{ __('STATUS') }} </th>
                    @if(\Auth::user()->type == 'Owner')
                    <th class="text-right"> {{__('Action')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @forelse ($meetings as $item)                    
                        <tr>
                            <td>{{$item->title}}</td>
                            @if(\Auth::user()->type == 'Owner')
                            <td>{{$item->course_name}}</td>
                            <td>
                                <div class="avatar-group">
                                    @foreach($item->students($item->student_id) as $projectUser)
                                        <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                            <img alt="" @if(!empty($users->avatar)) src="{{$profile.'/'.$projectUser->avatar}}" @else  avatar="{{(!empty($projectUser)?$projectUser->name:'')}}" @endif data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" data-toggle="tooltip" data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" class="">
                                        </a>
                                    @endforeach  
                                </div>                      
                            </td>
                            @endif
                            <td>{{$item->start_date}}</td>
                            <td>{{$item->duration}} {{__("Minutes")}}</td>                       
                            <td>
                                @if($item->created_by == \Auth::user()->current_store && $item->checkDateTime())
                                <a href="{{$item->start_url}}" target="_blank"> {{__('Start meeting')}} <i class="fas fa-external-link-square-alt "></i></a>
                                @elseif($item->checkDateTime())
                                    <a href="{{$item->join_url}}" target="_blank"> {{__('Join meeting')}} <i class="fas fa-external-link-square-alt "></i></a>
                                @else
                                    -
                                @endif

                            </td>
                            <td>
                                @if($item->checkDateTime())
                                    @if($item->status == 'waiting')
                                        <span class="badge badge-info">{{ucfirst($item->status)}}</span>
                                    @else
                                        <span class="badge badge-success">{{ucfirst($item->status)}}</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger">{{__("End")}}</span>
                                @endif
                            </td>
                            @if(\Auth::user()->type == 'Owner')
                            <td class="text-right">
                                <a  data-id="{{$item->id}}" class="delete-icon member_remove" data-toggle="tooltip" data-original-title="Delete"> <i class="fas fa-trash"></i> </a>
                            </td>
                            @endif
                        </tr>
                        @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    

@endsection
@push('script-page')   
<script src="{{url('assets/js/daterangepicker.js')}}"></script>
<script type="text/javascript">

$(document).on('change', '#course_id', function() {
    getStudents($(this).val());
});
function getStudents(id){
    $.get("{{url('get-students')}}/"+id, function(data, status){

        var list = '';
        $('#student_id').empty();
        if(data.length > 0){
            list += "<option value=''>  </option>";
        }else{
            list += "<option value=''> {{__('No Students')}} </option>";
        }
        $.each(data, function(i, item) {

            list += "<option value='"+item.id+"'>"+item.name+"</option>"  
        });
        $('#student_id').html(list);

    });
}
$(document).on("click", '.member_remove', function () {
    var rid = $(this).attr('data-id');
    $('.confirm_yes').addClass('m_remove');
    $('.confirm_yes').attr('uid', rid);
    $('#cModal').modal('show');
});
$(document).on('click', '.m_remove', function (e) {
    var id = $(this).attr('uid');
    var p_url = "{{url('zoom-meeting')}}"+'/'+id;
    var data = {id: id};
    deleteAjax(p_url, data, function (res) {
        show_toastr('Success', res.msg , 'success');
        $('#cModal').modal('hide');
        setTimeout(function() { 
            location.reload();
    }, 1000);     
    
    });
});
</script>
@endpush