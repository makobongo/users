<div class="tw-bg-white tw-p-5">
    <div class="tw-text-2xl">Update System Role - {{ $role->display_name  }}</div>
    <div class="tw-mt-5">
        {!! Form::open(['route' => ['users.role.update', $role->id], 'method' => 'patch']) !!}
    
        <div class="tw-flex tw-justify-between">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Role name') !!}
                {!! Form::text('name', $role->name, ['class' => 'form-control']) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
    
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::text('description', $role->description, ['class' => 'form-control']) !!}
            </div>
    
            <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Update role</button>

        </div>
    
    
        {!! Form::close() !!}
    </div>
</div>
