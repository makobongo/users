{!! Form::open(['files'=>true, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
<div class="box-body">
    <div class="col-md-6">
        <div class="form-group req {{ $errors->has('first_name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Employee',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <select class="form-control" name="employee" placeholder='Select Employee' required>
                    <optgroup label="Select an Employee">
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->profile->full_name}}</option>
                        @endforeach
                    </optgroup>
                </select>
                {!! $errors->first('employee', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group req {{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('injury', 'Select file to upload',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::file('file', ['class' => 'form-control', 'placeholder' => 'Injury']) !!}
                {!! $errors->first('file', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group req{{ $errors->has('category') ? ' has-error' : '' }}">
            {!! Form::label('category', 'Category',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::select('category',mconfig('users.options.chits'),null, ['class' => 'form-control','placeholder' => 'Select type']) !!}
                {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="form-group req{{ $errors->has('duration') ? ' has-error' : '' }}">
            {!! Form::label('duration', 'Duration',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-4">
                {!! Form::number('duration', old('duration'), ['class' => 'form-control', 'placeholder' => 'Duration']) !!}
                {!! $errors->first('time_measure', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="col-md-4">
                {!! Form::select('time_measure',mconfig('users.options.time_measure'),null, ['class' => 'form-control','placeholder' => 'Select Time Measure']) !!}
                {!! $errors->first('time_measure', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Remarks',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Remarks','rows'=>3]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <br>
        <button class="btn btn-default btn-flat pull-right" name="button" type="reset">Reset</button>
        <button type="submit" class="btn btn-primary btn-flat pull-right">Create</button>
    </div>
</div>
{!! Form::close() !!}