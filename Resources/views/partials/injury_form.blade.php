{!! Form::open() !!}
<div class="box-body">
    <div class="col-md-6">
        <div class="form-group req {{ $errors->has('first_name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Employee',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <select class="form-control" name="employee" placeholder='Select Employee' required>
                    <option></option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->profile->full_name}}</option>
                    @endforeach
                </select>
                {!! $errors->first('employee', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>

        <div class="form-group {{ $errors->has('injury') ? ' has-error' : '' }}">
            {!! Form::label('injury', 'Injury',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('injury', old('injury'), ['class' => 'form-control', 'placeholder' => 'Injury']) !!}
                {!! $errors->first('injury', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>

        <div class="form-group {{ $errors->has('statement') ? ' has-error' : '' }}">
            {!! Form::label('statement', 'Supervisor or Witness Statement',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::textarea('statement', old('statement'), ['class' => 'form-control', 'placeholder' => 'Statement','rows'=>3]) !!}
                {!! $errors->first('statement', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <br><br>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('check_roll_number') ? ' has-error' : '' }}">
            {!! Form::label('check_roll_number', 'Check Roll Number',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::text('check_roll_number', old('check_roll_number'), ['class' => 'form-control', 'placeholder' => 'Check Roll Number']) !!}
                {!! $errors->first('check_roll_number', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>
        <div class="form-group {{ $errors->has('remarks') ? ' has-error' : '' }}">
            {!! Form::label('tel', 'Nurse or C.O Remarks',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                {!! Form::textarea('remarks', old('remarks'), ['class' => 'form-control', 'placeholder' => 'Remarks.','rows'=>3]) !!}
                {!! $errors->first('remarks', '<span class="help-block">:message</span>') !!}
            </div>
        </div><br><br>
    </div>
    <div class="col-md-12">
        <br>
        <button class="btn btn-default btn-flat pull-right" name="button" type="reset">Reset</button>
        <button type="submit" class="btn btn-primary btn-flat pull-right">Create</button>
    </div>
</div>
{!! Form::close() !!}