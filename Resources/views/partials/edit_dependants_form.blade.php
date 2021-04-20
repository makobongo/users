@foreach($dependants as $dp)
<div class="col-md-12">
    <h3>{{$dp->first_name}}</h3>
    <div class="col-md-6">
        <input type="hidden" name="dp_id[]" value="{{$dp->id}}">
        <div class="form-group req {{ $errors->has('dp_first_name') ? ' has-error' : '' }}">
            {!! Form::label('dp_name', 'First Name',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('dp_first_name[]', $dp->first_name, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                {!! $errors->first('dp_first_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>
        <div class="form-group req {{ $errors->has('dp_last_name') ? ' has-error' : '' }}">
            {!! Form::label('dp_name', 'Last Name',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('dp_last_name[]', $dp->last_name, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                {!! $errors->first('dp_last_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>

        <div class="form-group {{ $errors->has('dp_relationship') ? ' has-error' : '' }}">
            {!! Form::label('dp_relationship', 'Relationship',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::select('dp_relationship[]',mconfig('users.options.relationship'),$dp->relationship, ['class' => 'form-control',]) !!}
                {!! $errors->first('dp_relationship', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>
    </div>

    <div class="col-md-6">
        <div class="form-group  {{ $errors->has('dp_middle_name') ? ' has-error' : '' }}">
            {!! Form::label('dp_name', 'Middle Name',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('dp_middle_name[]', $dp->middle_name, ['class' => 'form-control', 'placeholder' => 'Middle Name']) !!}
                {!! $errors->first('dp_middle_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>

        <div class="form-group req {{ $errors->has('dp_job') ? ' has-error' : '' }}">
            {!! Form::label('dp_dob', 'Date of Birth',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('dp_dob[]', $dp->dob, ['id' => 'dob','class' => 'form-control', 'placeholder' => 'Date of Birth','rows'=>3]) !!}
                {!! $errors->first('dp_dob', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <br><br>

        <div class="form-group {{ $errors->has('dp_photo') ? ' has-error' : '' }}">
            {!! Form::label('dp_photo', 'Photo',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <div class="col-md-8">
                    {!! Form::file('dp_photo[]',['class'=>'form-control']) !!}
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-default" id="webcam">
                        <i class="fa fa-camera-retro"></i> Capture</button>
                </div>
                {!! $errors->first('dp_photo', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
@endforeach
<h3>Add more dependants</h3>