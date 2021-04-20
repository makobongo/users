@extends('layouts.app')

@section('content_title','Injuries')
@section('content_description','Injuries that occur while an employee is on duty')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    @include('users::partials.injury_form')
                </div>
                <div class="box-body">
                    @if(!$injuries->isEmpty())
                    <table class="data-table table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Injury</th>
                                <th>Date Reported</th>
                                <th data-sortable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($injuries as $injury)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$injury->employees->profile->full_name}}</td>
                                <td>{{$injury->injury}}</td>
                                <td>{{$injury->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    @else
                    <p>
                        No Injuries have been recorded so far.
                    </p>
                    @endif
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col (MAIN) -->
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();

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
