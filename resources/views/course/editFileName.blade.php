{{Form::model($file_name,array('route' => array('practices.filename.update',[$file_name->id]), 'method' => 'PUT')) }}
<div class="row">
    <div class="form-group col-lg-12 col-md-12">
        {!! Form::label('file_name', __('File Name'),['class'=>'form-control-label']) !!}
        {!! Form::text('file_name', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <div class="w-100 text-right">
        <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}

