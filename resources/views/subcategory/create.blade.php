{!! Form::open(['route' => 'subcategory.store','method' => 'post']) !!}
<div class="row">
    <div class="form-group col-lg-6 col-md-6">
        {!! Form::label('name', __('Name'),['class'=>'form-control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <div class="form-group col-lg-6 col-md-6">
        {{Form::label('category',__('Category'),array('class'=>'form-control-label')) }}
        {!! Form::select('category', $category, null,array('class' => 'form-control')) !!}
    </div>
    <div class="w-100 text-right">
        <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}

