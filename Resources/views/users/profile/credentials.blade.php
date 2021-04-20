@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")
    
    {{ Form::model($user, ['method'=>'patch', 'url'=>route('users.update', $user->id), 'class' => 'form-horizontal']) }}
    
    <h2 class="tw-text-gray-600 tw-text-xl tw-text-center">Login Details</h2>

    <div class="tw-flex tw-flex-wrap tw-p-2">
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('login', 'Username',['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            {!! Form::text('user[username]', $user->username, ['class' => 'form-control', 'placeholder' => 'Username','autocomplete'=>'off']) !!}
            {!! $errors->first('user.username', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('confirm_username', 'Confirm', ['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            <input type="checkbox" name="user[confirm_username]">
            Confirm change of username
            {!! $errors->first('user.confirm_username', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('password', 'Current Password',['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            {!! Form::password('user[current]', ['class' => 'form-control', 'placeholder' => 'Current Password','autocomplete'=>'off']) !!}
            {!! $errors->first('user.current', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('password', 'New Password',['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            {!! Form::password('user[password]', ['class' => 'form-control', 'placeholder' => 'New Password','autocomplete'=>'off']) !!}
            {!! $errors->first('user.password', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('email', 'Email',['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            {!! Form::email('user[email]', $user->email, ['class' => 'form-control', 'placeholder' => 'User email']) !!}
            {!! $errors->first('user.email', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <div class="tw-w-1/3 tw-text-right tw-pr-4">
            {!! Form::label('confirm_email', 'Confirm', ['class'=>'control-label']) !!}
        </div>
        <div class="tw-w-2/3">
            <input type="checkbox" name="user[confirm_email]">
            Confirm change of email
            {!! $errors->first('user.confirm_email', '<span class="help-block">:message</span>') !!}
        </div>
    
        <div class="tw-w-full tw-my-2"></div>
    
        <button class="btn btn-success tw-ml-10">Update details</button>

    </div>

    {{ Form::close() }}

    @if(permit('users.hard-reset-user-password'))
        <a href="{{ route('users.hard-reset-password', $user->id) }}" class="btn btn-danger pull-right">
            <i class="fa fa-lock"></i> Hard Reset password to <code>12345678</code>
        </a>
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
@stop
