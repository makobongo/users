<?php extract($data);
//dd(user_is_doc(\Auth::user()));
?>
@extends('layouts.app')

@section('content_title','Users/Employees')
@section('content_description','View all users/employees')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> New User
                </a>
                <a href="{{ route('users.all') }}" class="btn btn-warning btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-list"></i> All Users
                </a>
            </div>
        </div>
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-sm-7 col-sm-offset-2">
                            {{--  search form  --}}
                            {{ Form::open(['method' => 'get']) }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}" placeholder="Search for Employee; ID Number, First Name, Middle Name, Last Name, CR Number">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Check-roll Number</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role(s)</th>
                                <th>Registered On</th>
                                <th data-sortable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->profile ? $user->profile->roll_no : '-' }}</td>
                                <td>
                                    {{ $user->profile ? $user->profile->full_name : ucfirst($user->username) }}
                                    <br/><small class="text-muted">{{ $user->profile ? 'ID: ' . $user->profile->id_number : '-' }}</small>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(count($user->roles) > 0)
                                        @foreach($user->roles as $role)
                                            {{ ucwords($role->name) }}
                                            @if(! $loop->last)
                                                |
                                            @endif
                                        @endforeach
                                    @endif

                                    @if($user->profile && $user->profile->partner_institution)
                                        <span class="label label-primary label-xs">External User</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                        
                                        <a href="{{ route('users.dependants', ['user'=>$user->id,'id'=>null]) }}" class="btn btn-info btn-xs"><i class="fa fa-child"></i> Dependants</a>

                                        @if($user->active)
                                        <a href="{{ route('users.deactivate', [$user->id]) }}" class="btn btn-warning btn-xs"><i class="fa fa-power-off"></i>Deactivate</a>
                                        @else
                                        <a href="{{ route('users.reactivate', [$user->id]) }}" class="btn btn-success btn-xs"><i class="fa fa-undo"></i>Reactivate</a>
                                        @endif
                                        <a href="{{ route('users.purge', [$user->id]) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                            <?php /* if ($user->id != $currentUser->id): ?>
                                              <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.user.user.destroy', [$user->id]) }}"><i class="fa fa-trash"></i></button>
                                              <?php endif; */ ?>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <hr/>
                    <!-- /.box-body -->
                    {{ $users->links() }}
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.col (MAIN) -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<!--include('core::partials.delete-modal')-->
@stop
