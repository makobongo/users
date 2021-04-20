@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")

@include('reports::partials.script')

<div class="col-md-12">
    @if(permit("users.dependants.store"))
        <p class="text-bold">Maximum allowed dependants per user: <strong>{{ m_setting('users.max_dependants_per_user') }}</strong></p>

        @if(! $user->dependants || count($user->dependants) < m_setting('users.max_dependants_per_user'))

            {{ Form::model($user, ['method'=>'patch', 'url'=>route('users.update', $user->id), 'files' => true, 'class' => 'form-horizontal']) }}

            <h2 class="panel-title panel-guide text-muted">Add a User Dependant</h2>

            {!! $errors->first('dependant.max-number', '<br/><div class="alert alert-error">:message</div>') !!}

            <div class="form-group col-md-8 req {{ $errors->has('dependant.first_name') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('first_name', 'First Name',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('dependant[first_name]', old('dependant.first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'first_name', 'required']) !!}
                        {!! $errors->first('dependant.first_name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 {{ $errors->has('dependant.middle_name') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('name', 'Middle Name',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('dependant[middle_name]', old('dependant.middle_name'), ['class' => 'form-control', 'placeholder' => 'Middle Name', 'id' => 'middle_name']) !!}
                        {!! $errors->first('dependant.middle_name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 req {{ $errors->has('dependant.last_name') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('name', 'Last Name',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('dependant[last_name]', old('dependant.last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'last_name', 'required']) !!}
                        {!! $errors->first('dependant.last_name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 req {{ $errors->has('dependant.gender') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('gender', 'Gender',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::select('dependant[gender]',mconfig('users.options.gender'),old('dependant.gender'), ['class' => 'form-control', 'id' => 'gender', 'required']) !!}
                        {!! $errors->first('dependant.gender', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 req {{ $errors->has('dependant.relationship') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('relationship', 'Relationship',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::select('dependant[relationship]',mconfig('users.options.relationship'), old("dependant.relationship"), ['class' => 'form-control', 'id' => 'relationship', 'required']) !!}
                        {!! $errors->first('dependant.relationship', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 req {{ $errors->has('dependant.dob') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('dob', 'Date of Birth', ['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        <input id="dob" type="text" class="form-control" name="dependant[dob]" value="{{ old('dependant.dob') }}">

                        {!! $errors->first('dependant.dob', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 {{ $errors->has('dependant.mobile') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('mobile', 'Mobile',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('dependant[mobile]', old('dependant.mobile'), ['class' => 'form-control', 'placeholder' => 'Mobile', 'id' => 'mobile']) !!}
                        {!! $errors->first('dependant.mobile', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 {{ $errors->has('dependant.photo') ? ' has-error' : '' }}">
                <div class="row">
                    {!! Form::label('photo', 'Photo',['class'=>'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::file('dependant[photo]',['class'=>'form-control col-md-3', 'id' => 'photo']) !!}
                        <button type="button" class="btn btn-default" id="webcam">
                            <i class="fa fa-camera-retro"></i> Capture
                        </button>
                        {!! $errors->first('dependant.photo', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="margin-top: 30px">
                    <button class="btn btn-success"><i class="fa fa-save"></i> Save Dependant</button>
                </div>
            </div>

            {{ Form::close() }}

        @else
            <p>The maximum number of dependants allowed for an employee has been reached.</p>
        @endif
    @else
        <p>Sorry! You do not have permission to perform this action.</p>
    @endif
</div>

<style>
    .form-horizontal .control-label {
        text-align: left !important; /* !important added for priority in SO snippet. */
    }

    .row>div>h4.form-header{
        font-size: 17px !important;
        color: #95a5a6;
    }
</style>

<script>
    $(document).ready(function () {
        $(".roles-selection").select2({
            theme: "bootstrap"
        });

        $('#dob').datepicker({
            maxDate: new Date,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
        });
    });
</script>
@stop