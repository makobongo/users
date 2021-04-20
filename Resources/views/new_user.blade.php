@extends('layouts.app')

@section('content-header')
<h1>New User</h1>
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal">
    <i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>Back</dd>
</dl>
@stop
@section('content')
{!! Form::open(['method' => 'post','route'=>'users.store', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Details</a></li>
                <!--
                <li class=""><a href="#tab_3-3" data-toggle="tab">Permissions</a></li>
                -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group req {{ $errors->has('title') ? ' has-error' : '' }}">
                                {!! Form::label('title', 'Title',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::select('title',mconfig('users.users.titles') ,old('title'), ['class' => 'form-control',]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group req {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'First Name',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', 'required']) !!}
                                    {!! $errors->first('first_name', '<span class="help-block alert alert-danger">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group  {{ $errors->has('middle_name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Middle Name',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('middle_name', old('middle_name'), ['class' => 'form-control', 'placeholder' => 'Middle Name']) !!}
                                    {!! $errors->first('middle_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group req {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Last Name',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name', 'required']) !!}
                                    {!! $errors->first('last_name', '<span class="help-block alert alert-danger">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('id_number') ? ' has-error' : '' }}">
                                {!! Form::label('id_number', 'ID Number',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::number('id_number', old('id_number'), ['class' => 'form-control', 'placeholder' => 'ID Number']) !!}
                                    {!! $errors->first('id_number', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            @if(m_setting('users.enable_check_roll_number'))
                                <div class="form-group req {{ $errors->has('roll_no') ? ' has-error' : '' }}">
                                    {!! Form::label('name', 'Check-roll Number',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('roll_no', old('roll_no'), ['class' => 'form-control', 'placeholder' => 'Roll Number', 'required']) !!}
                                        {!! $errors->first('roll_no', '<span class="help-block alert alert-danger">:message</span>') !!}
                                    </div>
                                </div>
                            @endif

                            <div class="form-group req {{ $errors->has('gender') ? ' has-error' : '' }}">
                                {!! Form::label('gender', 'Gender',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::select('gender',mconfig('users.options.gender'),old('gender'), ['class' => 'form-control',]) !!}
                                    {!! $errors->first('gender', '<span class="help-block alert alert-danger">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group req {{ $errors->has('dob') ? ' has-error' : '' }}">
                                {!! Form::label('dob', 'Date of Birth',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::date('dob', old('dob'), ['id' => 'dob','class' => 'form-control', 'placeholder' => 'Date of Birth','rows'=>3, 'required']) !!}
                                    {!! $errors->first('dob', '<span class="help-block alert alert-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('mpdb') ? ' has-error' : '' }}">
                                {!! Form::label('mpdb', 'MPDB No',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('mpdb', old('mpdb'), ['class' => 'form-control', 'placeholder' => 'MPDB number']) !!}
                                    {!! $errors->first('mpdb', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                {!! Form::label('tel', 'Mobile',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('mobile', old('mobile'), ['class' => 'form-control', 'placeholder' => 'Mobile No.']) !!}
                                    {!! $errors->first('mobile', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group req {{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email', 'Email',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'User email']) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('is_user', 'Employee is User',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    <input type="checkbox" class="external_doctor" name="is_user" id="is_user">
                                    <small>
                                        <i>Employee will use the system</i>
                                    </small>
                                </div>
                            </div>

                            <div class="partners">
                                <div class="form-group {{ $errors->has('login') ? ' has-error' : '' }}">
                                    {!! Form::label('login', 'Login ID',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('login', null, ['class' => 'form-control', 'placeholder' => 'Username','autocomplete'=>'off']) !!}
                                        {!! $errors->first('login', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    {!! Form::label('password', 'Password',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password','autocomplete'=>'off']) !!}
                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="form-group req">
                                    <label class="col-md-4">Role(s)</label>
                                    <div class="col-md-8">
                                        <select multiple="" class="form-control" name="roles[]">
                                            <?php foreach ($roles as $role): ?>
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('employee_category') ? ' has-error' : '' }}">
                                {!! Form::label('employee_category', ucwords('employee category'),['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    <select name="employee_category" id="employee-category" class="form-control">
                                        @foreach($employee_categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('users.employee-categories.index') }}" target="_blank"><i class="fa fa-pencil"></i> Add Employee Category</a>
                                    {!! $errors->first('employee_category', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('job') ? ' has-error' : '' }}">
                                {!! Form::label('job', 'Job Description',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    {!! Form::textarea('job', old('job'), ['class' => 'form-control', 'placeholder' => 'Job Description','rows'=>3]) !!}
                                    {!! $errors->first('job', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                        </div>
                        {{--add insurance panel--}}
                        @include('users::partials.employee_insurance')
                    </div>
                </div>

            <!--
                <div class="tab-pane" id="tab_3-3">
                    <div class="box-body">
                        @include('users::partials.permissions-create')
                    </div>
                </div> -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Create</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset"><i class="fa fa-history"></i> Reset</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('users.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>

    </div>

</div>


{!! Form::close() !!}
@include('users::partials.webcam')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>Back</dd>
</dl>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $(".partners").hide();
            $(".external_doctor").click(function () {
                if ($(this).is(":checked")) {
                    $(".partners").show(300);
                } else {
                    $(".partners").hide(200);
                }
            });

            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "{{route('users.index')}}"}
                ]
            });
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            $("#dob").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y'});
            $("#dp_dob").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y'});
            $('.rel').select2();
        });

    </script>
@stop
