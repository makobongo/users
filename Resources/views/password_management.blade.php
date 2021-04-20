@extends('layouts.app')

@section('content_title','Password Management')
@section('content_description','Manage your password')

@section('content')
	<div class="row">
	    <div class="col-xs-12">
	        <div class="box box-primary">
	            <div class="box-header">
	            	<p>Please keep note of your password. Upon changing your password, you will be redirected to the login page.</p>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	                <div class="row">
						<div class="col-sm-6 col-sm-offset-3">

							{{ Form::open(['method' => 'POST', 'route' => 'users.manage-password-post', 'class'=>'form-horizontal']) }}

								<div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
				                    {!! Form::label('old_password', ucwords('old password'),['class'=>'control-label col-md-4']) !!}
				                    <div class="col-md-8">
				                        {!! Form::password('old_password', null, ['class' => 'form-control', 'required']) !!}
					                    {!! $errors->first('old_password', '<span class="help-block">:message</span>') !!}
				                    </div>
				                </div>
				                <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
				                    {!! Form::label('new_password', ucwords('new password'),['class'=>'control-label col-md-4']) !!}
				                    <div class="col-md-8">
				                        {!! Form::password('new_password', null, ['class' => 'form-control', 'required']) !!}
					                    {!! $errors->first('new_password', '<span class="help-block">:message</span>') !!}
				                    </div>
				                </div>
				                <div class="form-group {{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
				                    {!! Form::label('new_password_confirmation', ucwords('confirm password'),['class'=>'control-label col-md-4']) !!}
				                    <div class="col-md-8">
				                        {!! Form::password('new_password_confirmation', null, ['class' => 'form-control', 'required', 'autocomplete' => false]) !!}
					                    {!! $errors->first('new_password_confirmation', '<span class="help-block">:message</span>') !!}
				                    </div>
				                </div>

				                <div class="form-group  text-center">
				                	<button type="submit"><i class="fa fa-save"></i> Change Password</button>
				                </div>

							{{ Form::close() }}

						</div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
