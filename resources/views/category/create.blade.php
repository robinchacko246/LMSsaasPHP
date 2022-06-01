{!! Form::open(['route' => 'category.store','method' => 'post', 'enctype'=>'multipart/form-data']) !!}
<div class="row">
    <div class="form-group col-lg-6 col-md-6">
        {!! Form::label('name', __('Name'),['class'=>'form-control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <div class="form-group col-lg-6">
        <div class="col-12">
            <div class="form-group">
                <label for="category_image" class="form-control-label">{{ __('Upload category_image') }}</label>
                <input type="file" name="category_image" id="category_image" class="custom-input-file">
                <label for="category_image">
                    <i class="fa fa-upload"></i>
                    <span>{{__('Choose a image')}}</span>
                </label>
            </div>
        </div>
    </div>
    <div class="w-100 text-right">
        <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}

