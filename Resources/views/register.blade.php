@extends('layouts.account')
@section('title')
Register | @parent
@stop

@section('content')
<div class="register-logo">
    <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
</div>

<div class="register-box-body">
    <p class="login-box-msg">Create your account</p>
    @include('flash::message')
    {!! Form::open(['route' => 'public.register.post']) !!}
    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
        <input type="email" name="email" class="form-control" autofocus
               placeholder="Email" value="{{ old('email') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
    </div>
    <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error has-feedback' : '' }}">
        <input type="text" name="username" class="form-control" autofocus
               placeholder="Username" value="{{ old('username') }}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
    </div>
    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
    </div>
    {!! Form::close() !!}

    <a href="{{ route('public.login') }}" class="text-center">I have an account, Login</a>
</div>
@stop
