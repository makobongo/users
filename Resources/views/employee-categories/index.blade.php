@extends('layouts.app')

@section('content_title','Employee Categories')

@section('content-header')
<h1> Employee Categories</h1>
@stop

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{route('users.employee-categories.create') }}" class="btn btn-primary btn-flat toggle-form-btn" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> New Employee Category
                </a>
            </div>
        </div>

        <div class="{{ !isset($employee_category) ? 'form-for-toggling' : '' }}">
            <div class="box box-danger">
                <div class="box-body">
                    @include('users::employee-categories._form')
                </div>
            </div>
        </div>


        <div class="box box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="data-table table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>#</td>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee_categories as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }} </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('users.employee-categories.edit', [$item->id]) }}" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('users.employee-categories.destroy', [$item->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>#</td>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col (MAIN) -->
    </div>
</div>
@include('core::partials.delete-modal')
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).keypressAction({
            actions: [
                {key: 'c', route: "<?= route('users.employee-categories.create') ?>"}
            ]
        });

        $('.toggle-form-btn').on('click', function (e) {
            var target_element = $('.form-for-toggling');
            if(target_element.length) {
                e.preventDefault();
                target_element.toggle(300);
            }
        });
    });
</script>
@stop
