@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")

@php
    $userRoles = $user->roles->pluck("id")->all();
@endphp

<div class="col-md-12">
    {{ Form::open(['method'=>'patch', 'url'=>route('users.update', $user->id), 'class' => 'form-horizontal']) }}

    <h2 class="panel-title panel-guide">Roles Assigned to User</h2>

    <div class="form-group col-md-8 {{ $errors->has('roles') ? ' has-error' : '' }}">
        <div class="row">
            {!! Form::label('role', 'Assign Roles',['class'=>'control-label col-md-3']) !!}
            <div class="col-md-9">
                <select class="form-control roles-selection" name="roles[]" multiple>
                    @foreach($roles->all() as $role)
                        <option value="{{ $role->id }}" @if(in_array($role->id, $userRoles)) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
                {!! $errors->first('roles', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="margin-top: 30px">
            <button class="btn btn-success">Update roles</button>
        </div>
    </div>

    {{ Form::close() }}
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $(".roles-selection").select2({
                theme: "bootstrap"
            });
        });
    </script>
@stop