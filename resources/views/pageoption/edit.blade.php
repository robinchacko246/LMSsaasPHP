{{Form::model($pageOption, array('route' => array('custom-page.update', $pageOption->id), 'method' => 'PUT')) }}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('name',__('Name'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name')))}}
            @error('name')
            <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group col-md-6">
        {{Form::label('enable_page_header',__('Page Header Display'),array('class'=>'form-control-label mb-3')) }}
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="enable_page_header" id="enable_page_header" {{ ($pageOption['enable_page_header'] == 'on') ? 'checked=checked' : '' }}>
            <label class="custom-control-label form-control-label" for="enable_page_header"></label>
        </div>
    </div>
    <div class="form-group col-md-6">
        {{Form::label('enable_page_footer',__('Page Footer Display'),array('class'=>'form-control-label mb-3')) }}
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="enable_page_footer" id="enable_page_footer" {{ ($pageOption['enable_page_footer'] == 'on') ? 'checked=checked' : '' }}>
            <label class="custom-control-label form-control-label" for="enable_page_footer"></label>
        </div>
    </div>
    <div class="form-group col-md-12">
        {{Form::label('contents',__('Contents'),array('class'=>'form-control-label')) }}
        {{Form::textarea('contents',null,array('class'=>'form-control summernote-simple','rows'=>3,'placehold   er'=>__('Contents')))}}
        @error('contents')
        <span class="invalid-contents" role="alert">
             <strong class="text-danger">{{ $message }}</strong>
         </span>
        @enderror
    </div>
</div>
<div class="text-right">
    {{Form::submit(__('Update'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
</div>
{{Form::close()}}
