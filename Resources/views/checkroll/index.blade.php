@extends('layouts.app')

@section('content_title','Check roll numbers')
@section('content_description','View & update check roll numbers')

@section('content')
<style>
    .dataTables_filter input { width: 300px !important }
</style>

<div class="box box-info">
    <div class="box-header bg-info">
        <div class="box-title">Users List <small>Update user check-roll no</small></div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    {{ Form::open(['class' => 'form', 'url' => request()->url(), 'method' => 'GET']) }}
                        {{ Form::hidden('search', true) }}

                        <div class="col-sm-4">
                            <div class="form-group">
                                {{ Form::label('names', 'First/Middle/Last Name', ['class' => 'form-label']) }}
                                {{ Form::text('names', request('names'), ['class' => 'form-control', 'placeholder' => 'First/Middle/Last Name']) }}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::label('roll_no', 'Checkroll Roll No.', ['class' => 'form-label']) }}
                                {{ Form::text('roll_no', request('roll_no'), ['class' => 'form-control', 'placeholder' => 'CheckRoll Number']) }}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::label('id_number', 'ID No.', ['class' => 'form-label']) }}
                                {{ Form::text('id_number', request('id_number'), ['class' => 'form-control', 'placeholder' => 'ID Number']) }}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <br/>
                            <button type="submit" class="btn btn-primary btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                            <a href="{{ request()->url() }}" class="btn btn-success btn-flat pull-right">
                                <i class="fa fa-list"></i> View All
                            </a>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>

            <div class="col-sm-12">
                @if($users->hasMorePages())
                    <h4 class="text-muted">Load More Results</h4>
                @endif
                {{ $users->appends(request()->all())->links() }}

                <div class="table-responsive">
                    <table class="table" id="users-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Names</th>
                                <th>ID</th>
                                <th>CheckRoll No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->profile->full_name }}</td>
                                    <td>{{ $item->profile->id_number }}</td>
                                    <td>{{ $item->profile->roll_no }}</td>
                                    <td>
                                        <button
                                            class="btn btn-primary btn-flat btn-sm update-btn"
                                            data-name="{{ $item->profile->full_name}}"
                                            data-roll-no="{{ $item->profile->roll_no }}"
                                            data-id="{{ $item->id }}"
                                        >
                                            <i class="fa fa-pencil"></i> Update
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="update-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {{ Form::open(['class' => 'form']) }}
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span id="update-modal-title"></span> </h4>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('user_id', null, ['id' => 'user_id']) }}

                    <div class="form-group">
                        {{ Form::label('roll_no', 'Check Roll No.', ['class' => 'form-label']) }}
                        {{ Form::text('roll_no', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-flat">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Update CheckRoll No.</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var USERS_TABLE_URL = "{{ route('users.checkroll.index') }}";
        var table = $('#users-table');
        table.dataTable({
        });

        var update_modal = $('#update-modal');

        $('body').on('click', '.update-btn', function(e) {
            e.preventDefault();
            var user_id = $(this).data('id');
            var roll_no = $(this).data('roll-no');
            var user_name = $(this).data('name');
            update_modal.find('#update-modal-title').text(user_name);
            update_modal.find('#user_id').val(user_id);
            update_modal.find('#roll_no').val(roll_no);
            update_modal.modal('show');
        });

        update_modal.find('form').submit(function(e) {
            e.preventDefault();

            update_modal.modal('hide');
            var data = $(this).serialize();
            var url = "{{ route('users.checkroll.update') }}";
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(response) {
                    alertify.success('updated');
                    window.location.reload();
                },
                error: function(error) {
                    alertify.error('an error occurred! Please refresh the page');
                }
            });
        });
    });
</script>
@endsection