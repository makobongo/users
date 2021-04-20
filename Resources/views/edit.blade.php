@extends('layouts.app')

@section('content_title','Edit User')
@section('content_description','Edit user <b>'.$user->profile->full_name.'</b>')


@section('content')
{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">User</a></li>
                <li class=""><a href="#tab_2-2" data-toggle="tab">Roles</a></li>
                <li class=""><a href="#tab_3-3" data-toggle="tab">Permissions</a></li>
                <li class=""><a href="#clinic_tab" data-toggle="tab">Assign Clinic(s)</a></li>
                <li class=""><a href="#password_tab" data-toggle="tab">Password</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    {!! Form::label('title', 'Title') !!}
                                    {!! Form::select('title',mconfig('users.users.titles') ,old('title'), ['class' => 'form-control',]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    {!! Form::label('username', 'Username') !!}
                                    {!! Form::text('username', old('username', $user->username), ['class' => 'form-control', 'placeholder' =>'Username']) !!}
                                    {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    {!! Form::label('first_name', 'First name') !!}
                                    {!! Form::text('first_name', old('first_name', $user->profile->first_name), ['class' => 'form-control', 'placeholder' =>'First name']) !!}
                                    {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    {!! Form::label('last_name', 'Last name') !!}
                                    {!! Form::text('last_name', old('last_name', $user->profile->last_name), ['class' => 'form-control', 'placeholder' => 'Last name']) !!}
                                    {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::email('email', old('email', $user->email), ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    {!! Form::label('phone', 'Phone Number') !!}
                                    {!! Form::text('phone', old('phone', $user->profile->phone), ['class' => 'form-control', 'placeholder' => 'Phone Number']) !!}
                                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('id_number') ? ' has-error' : '' }}">
                                    {!! Form::label('ID Number', 'ID Number') !!}
                                    {!! Form::number('id_number', old('id_number',$user->profile->id_number), ['class' => 'form-control', 'placeholder' => 'ID Number']) !!}
                                    {!! $errors->first('id_number', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if(m_setting('users.enable_check_roll_number'))
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('roll_no') ? ' has-error' : '' }}">
                                        {!! Form::label('roll_no', 'Check-roll Number') !!}
                                        {!! Form::text('roll_no', old('roll_no', $user->profile->roll_no), ['class' => 'form-control', 'placeholder' => 'Check-Roll Number']) !!}
                                        {!! $errors->first('roll_no', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                    {!! Form::label('dob', 'Date of Birth') !!}
                                    {!! Form::date('dob', old('dob', $user->profile->dob), ['class' => 'form-control', 'placeholder' => 'Date of Birth']) !!}
                                    {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    {!! Form::label('gender', 'Gender') !!}
                                    {!! Form::select('gender',mconfig('users.options.gender'),$user->profile->gender, ['class' => 'form-control',]) !!}
                                    {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('mpdb') ? ' has-error' : '' }}">
                                    {!! Form::label('mpdb', 'MPDB') !!}
                                    {!! Form::text('mpdb', old('mpdb', $user->profile->mpdb), ['class' => 'form-control', 'placeholder' => 'MPDB']) !!}
                                    {!! $errors->first('mpdb', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                                    {!! Form::label('pin', 'Pin') !!}
                                    {!! Form::text('pin', old('pin', $user->profile->pin), ['class' => 'form-control', 'placeholder' => 'Pin']) !!}
                                    {!! $errors->first('pin', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('job_description') ? ' has-error' : '' }}">
                                    {!! Form::label('Job Description', 'Job Description') !!}
                                    {!! Form::textarea('job_description', old('job_description',$user->profile->job_description), ['class' => 'form-control', 'placeholder' => 'Job Description','rows'=>3]) !!}
                                    {!! $errors->first('job_description', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('credit') ? ' has-error' : '' }}">
                                    {!! Form::label('credit', 'Credit Amount') !!}
                                    {!! Form::text('credit', old('credit', $user->profile->credit), ['class' => 'form-control', 'placeholder' => '0']) !!}
                                    {!! $errors->first('credit', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <div class="checkbox{{ $errors->has('activated') ? ' has-error' : '' }}">
                                    <input type="hidden" value="{{ $user->id === $currentUser->id ? '1' : '0' }}" name="activated"/>
                                    <?php $oldValue = (bool) $user->isActivated() ? 'checked' : ''; ?>
                                    <label for="activated">
                                        <input id="activated" name="activated" type="checkbox" class="flat-blue" {{ $user->id === $currentUser->id ? 'disabled' : '' }} {{ old('activated', $oldValue) }} value="1" />
                                        Activated
                                        {!! $errors->first('activated', '<span class="help-block">:message</span>') !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Roles</label>
                                <select multiple="" class="form-control select2" name="roles[]" style="width: 100%;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" <?php echo $user->hasRoleId($role->id) ? 'selected' : '' ?>>{{ ucwords($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- permissions -->
                <div class="tab-pane" id="tab_3-3">
                    <div class="box-body">
                        @include('users::partials.permissions', ['model' => $user])
                    </div>
                </div>

                <!-- clinic -->
                <div class="tab-pane" id="clinic_tab">
                    <div class="box-body">
                        @include('users::partials.clinic', ['model' => $user])
                    </div>
                </div>

                <div class="tab-pane" id="password_tab">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>New Password</h4>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {!! Form::label('password', 'New password') !!}
                                    {!! Form::input('password', 'password', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    {!! Form::label('password_confirmation', 'Confirm password') !!}
                                    {!! Form::input('password', 'password_confirmation', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Rest password</h4>
                                <a href="{{ route("users.sendResetPassword", $user->id) }}" class="btn btn-flat bg-maroon">
                                    Send reset password mail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Update</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('users.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>Back to index</dd>
</dl>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2();

        $('[data-toggle="tooltip"]').tooltip();
        $(document).keypressAction({
            actions: [
                {key: 'b', route: "<?= route('users.role.index') ?>"}
            ]
        });
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    });
</script>
@stop
