{{Form::open(array('url'=>'blog','method'=>'post','enctype'=>'multipart/form-data'))}}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('title',__('Title')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title'),'required'=>'required'))}}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="blog_cover_image" class="form-control-label">{{ __('Blog Cover image') }}</label>
            <input type="file" name="blog_cover_image" id="blog_cover_image" class="custom-input-file">
            <label for="blog_cover_image">
                <i class="fa fa-upload"></i>
                <span>{{__('Choose a file')}}</span>
            </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        {{Form::label('detail',__('Detail'),array('class'=>'form-control-label')) }}
        {{Form::textarea('detail',null,array('class'=>'form-control summernote-simple','rows'=>3,'placeholder'=>__('Detail')))}}
    </div>
    <div class="w-100 text-right">
        {{Form::submit(__('Save'),array('class'=>'btn btn-sm btn-primary rounded-pill mr-auto'))}}
    </div>
</div>
{{Form::close()}}
