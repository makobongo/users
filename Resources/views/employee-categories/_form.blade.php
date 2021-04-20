<?php

    if (isset($employee_category)) {
        $method = 'PUT';
        $url = route('users.employee-categories.update', $employee_category->id);
    } else {
        $method = 'POST';
        $url = route('users.employee-categories.store');
    }

?>

{{ Form::open(['class'=>'form-horizontal', 'role'=>'form', 'method'=>$method, 'url'=>$url]) }}
    <div class="row">
        {{--  name  --}}
        <div class="col-sm-4">
            <div class="form-group  {{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', ucwords('name *'),['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {{ Form::text('name', isset($employee_category) ? $employee_category->name : old('name'), ['class' => 'form-control', 'placeholder' => 'Full Employment']) }}
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        {{--  description  --}}
        <div class="col-sm-8">
            <div class="form-group  {{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', ucwords('description *'),['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    {{ Form::textarea('description', isset($employee_category) ? $employee_category->description : old('description'), ['class' => 'form-control', 'placeholder' => 'Employee on Full Employment', 'rows' => 2]) }}
                    {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        {{--  submit  --}}
        <div class="col-md-3 col-md-offset-8 text-right">
            <div class="form-group">
                <button type="reset" class="btn btn-secondary btn-flat"><i class="fa fa-history"></i> Clear Form</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Submit</button>
            </div>
        </div>

    </div>

{{ Form::close() }}
