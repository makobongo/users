<div class="tw-bg-white tw-p-5">
    <div class="tw-text-2xl">Add New System Role</div>
    
    <div class="tw-mt-5">
        {!! Form::open(['route' => 'users.role.store', 'method' => 'post']) !!}
        <div class="tw-flex tw-justify-between">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Role name') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::text('description', old('description'), ['class' => 'form-control']) !!}
            </div>
    
            <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Save role</button>

        </div>
    
        {!! Form::close() !!}
    </div>
</div>
