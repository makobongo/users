@extends('layouts.app')

@section('content_title','Upload Users File')

@section('content')
<div class="row" >
    <div class="col-md-12">

        {{Form::open(['route' => 'users.upload', 'files' => true])}}

        <div class="form-group  {{ $errors->has('middle_name') ? ' has-error' : '' }}">
            <div class="col-md-8">
                {{Form::file('userfile',['id' => 'file','accept' => '.xls, .xlsx'])}}
            </div>
        </div><br><br>

        <div class="form-group  {{ $errors->has('middle_name') ? ' has-error' : '' }}">
            <div class="col-md-8">
                {{Form::submit('upload file',['id' => 'upload'])}}
            </div>
        </div><br><br>

        {{Form::close()}}
    </div>
</div>

@if(false)
    <table id="employees_table" class="table table-condensed table-responsive table-striped">
        <thead>
        <tr>
            @foreach( $result['titles'] as $item)
                <th>{{$item}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>

                @foreach( $result['data'] as $datum)
                    <tr>
                        @if( is_array($datum) )
                            @foreach( $datum as $key => $value)
                                <td>{{$value}}</td>
                            @endforeach
                        @else
                            <td>{{$datum}}</td>
                        @endif
                    </tr>
                @endforeach

        </tbody>
    </table>
@endif


    <table id="employees_table" class="table table-condensed table-responsive table-striped" >
        <thead>
        <tr>
            <th>Document Columns</th>
            <th>Use as</th>
        </tr>
        </thead>
        <tbody>
            @if(isset($result))
                @foreach($result['titles'] as $title)
                    <tr>
                        <td>{{$title}}</td>
                        <td>
                            <div class="col-md-8">
                                {!! Form::select('title',get_db_columns(),old('title'), ['class' => 'form-control',]) !!}
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@stop


<script>
    $(document).ready(function () {
        $('#employees_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "aaSorting" : []
        });
    });

</script>