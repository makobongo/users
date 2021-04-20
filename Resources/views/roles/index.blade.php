@extends('layouts.app')

@section('content_title','User roles')
@section('content_description','Create/view system roles')

@section('content')

    @if(permit("users.roles.store") and !isset($role))
        @include("users::roles.create")
    @endif

    @if(permit("users.roles.update") and isset($role))
        @include("users::roles.edit")
    @endif

    <div class="tw-bg-white tw-p-5 tw-mt-5">
        <div class="tw-text-2xl">System Roles</div>
        <div class="tw-mt-5">
            <table id="table" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <a href="{{ route("users.role.edit", $role->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Edit Role</a>
                            <a href="{{ route("users.role-permissions", $role->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-legal"></i> permissions</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop

@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                // 'copy', 'excel', 'pdf'
            ]
        });
    });
</script>
@stop
