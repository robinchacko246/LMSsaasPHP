{!! Form::open(array('route' => array('store_rating',$slug,$course_id,$tutor_id), 'method' => 'POST')) !!}
<div class="container-fluid">
    <div class="row">
        <div class="form-group col-lg-12">
            {{Form::label('name',__('Name')) }}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
        </div>
        <div class="form-group col-lg-12">       
            {{Form::label('title',__('Title')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title'),'required'=>'required'))}}       
        </div>
        <div class="form-group col-sm-6 pb-2">
            {{Form::label('title',__('Ratting')) }}
            <div id="rating_div">
                <div class="rate pl-0">
                    <input type="radio" class="rating" id="star5" name="rate" value="5">
                    <label for="star5" title="Very Happy">5 stars</label>
                    <input type="radio" class="rating" id="star4" name="rate" value="4">
                    <label for="star4" title="Somewhat Happy">4 stars</label>
                    <input type="radio" class="rating" id="star3" name="rate" value="3">
                    <label for="star3" title="Neither happy nor sad">3 stars</label>
                    <input type="radio" class="rating" id="star2" name="rate" value="2">
                    <label for="star2" title="Somewhat Sad">2 stars</label>
                    <input type="radio" class="rating" id="star1" name="rate" value="1">
                    <label for="star1" title="Very Sad">1 star</label>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description')) }}
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <div class="form-group">
                <button type="submit" class="submit_button">{{ __('Save Changes') }}</button>
            </div>
        </div>
    </div>
</div>
{{Form::close()}}
