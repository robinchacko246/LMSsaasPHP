{{Form::model($faq,array('route' => array('faqs.update',[$faq->id,$course_id]), 'method' => 'PUT')) }}
<div class="row">
    <div class="form-group col-lg-12 col-md-12">
        {!! Form::label('question', __('Question'),['class'=>'form-control-label']) !!}
        {!! Form::text('question', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <div class="form-group col-lg-12 col-md-12">
        {!! Form::label('answer', __('Answer'),['class'=>'form-control-label']) !!}
        {!! Form::textarea('answer', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <div class="w-100 text-right">
        <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}

