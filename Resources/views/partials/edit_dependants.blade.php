@include('users::partials.edit_dependants_form')
<div id="dependants"  class="dependants">
    <div id="wrapper1">
        <div class="col-md-6">
            <div class="form-group req {{ $errors->has('dp_first_name') ? ' has-error' : '' }}">
                {!! Form::label('dp_name', 'First Name',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {!! Form::text('dp_first_name[]', old('dp_first_name[]'), ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                    {!! $errors->first('dp_first_name', '<span class="help-block">:message</span>') !!}
                </div>
            </div><br><br>
            <div class="form-group req {{ $errors->has('dp_last_name') ? ' has-error' : '' }}">
                {!! Form::label('dp_name', 'Last Name',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {!! Form::text('dp_last_name[]', old('dp_last_name[]'), ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                    {!! $errors->first('dp_last_name', '<span class="help-block">:message</span>') !!}
                </div>
            </div><br><br>

            <div class="form-group {{ $errors->has('dp_relationship') ? ' has-error' : '' }}">
                {!! Form::label('dp_relationship', 'Relationship',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {!! Form::select('dp_relationship[]',mconfig('users.options.relationship'),old('dp_relationship'), ['class' => 'form-control',]) !!}
                    {!! $errors->first('dp_relationship', '<span class="help-block">:message</span>') !!}
                </div>
            </div><br><br>
        </div>

        <div class="col-md-6">
            <div class="form-group  {{ $errors->has('dp_middle_name') ? ' has-error' : '' }}">
                {!! Form::label('dp_name', 'Middle Name',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {!! Form::text('dp_middle_name[]', old('dp_middle_name'), ['class' => 'form-control', 'placeholder' => 'Middle Name']) !!}
                    {!! $errors->first('dp_middle_name', '<span class="help-block">:message</span>') !!}
                </div>
            </div><br><br>

            <div class="form-group req {{ $errors->has('dp_job') ? ' has-error' : '' }}">
                {!! Form::label('dp_dob', 'Date of Birth',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {!! Form::text('dp_dob[]', old('dp_dob'), ['id' => 'dob','class' => 'form-control', 'placeholder' => 'Date of Birth','rows'=>3]) !!}
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
</div>
<br><br>

<script>
    $(document).ready(function () {
        $("#dob").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y'});
        $(".test_select").select2();
    });
</script>
<button class="add_button btn btn-xs btn-primary">
    <i class="fa fa-plus-square-o"></i>Add Record
</button>
<script src="{{m_asset('users:js/dependants.js')}}"></script>