@extends('layouts.app')

@section('content_title','Chits')
@section('content_description','i.e Referral note and paid sick chit')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body">
                <div class="row">
                    @include('users::chits._form')
                </div>

                @if(!$chits->isEmpty())
                    <table class="data-table table table-bordered table-hover table-striped">
                        <thead class="bg-info">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Created On</th>
                                <th data-sortable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chits as $chit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chit->employee->profile->full_name }}</td>
                                <td>{{ ucwords($chit->category) }}</td>
                                <td>{{ $chit->duration_friendly }}</td>
                                <td>{{ $chit->created_at->format('jS M, Y') }}</td>
                                <td>
                                    <div class="">
                                        <a href="{{ asset('employee/chits/' . $chit->filename) }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-success btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <a href="{{route('users.chits.print', $chit->id)}}" class="btn btn-warning btn-xs" target="_blank">
                                            <i class="fa fa-print"></i> PDF
                                        </a>

                                        <a href="{{route('users.chits.delete',$chit->id)}}" class="btn btn-danger btn-xs pull-right">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">No Chits Recorded so far</div>
                @endif
            </div>
        </div>
    </div>
</div>
{{--  include('core::partials.delete-modal')  --}}
<script>
    $(document).ready(function () {
        $('select').select2();
        $('table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    customize: function ( win ) {
                        $(win.document).find('table')
                            .addClass( 'table' )
                            .css( 'font-size', 'inherit' );
                    }
                },
                {
                    extend: 'pdf',
                    customize: function (win) {
                        $(win.document).find('table')
                            .addClass('table')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                }
            ]
        });

    });
</script>
@stop
