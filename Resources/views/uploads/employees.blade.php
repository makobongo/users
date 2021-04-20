@extends('layouts.app')

@section('content_title','Uploads Section')
@section('content_description','Upload Employees from Excel Worksheet')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
            	Upload a valid Excel Worksheet containing a list of Employees.
            </div>
            <!-- /.box-header -->

            <div class="box-body">
            	<h4 class=" title text-muted">Worksheet Headers</h4>
            	<table class="table">
            		<thead class="bg-primary">
            			<tr>
            				<th>Title *</th>
            				<th>First Name *</th>
            				<th>Middle Name</th>
            				<th>Last Name *</th>
            				<th>ID No *</th>
            				<th>CR No (Roll No)</th>
            				<th>Gender *</th>
            				<th>Date of Birth *</th>
            				<th>Tel No.</th>
            				<th>PIN</th>
            			</tr>
            		</thead>
					<tbody>
						<tr>
							<td>Mr</td>
							<td>John</td>
							<td>Doe</td>
							<td>Kent</td>
							<td>1234567</td>
							<td>422</td>
							<td>male</td>
							<td>17-02-2018</td>
							<td>0701000111</td>
							<td>A00111222</td>
						</tr>
					</tbody>
            	</table>
            	<hr/>

            	<h4 class=" title text-muted">Let's upload a worksheet</h4>
				{{ Form::open(['route' => 'users.upload.employees.store', 'method' => 'post', 'files' => true, 'class' => 'form-horizontal']) }}
                	<div class="row">
                		<div class="col-sm-6">
                			<div class="form-group  {{ $errors->has('scheme_id') ? ' has-error' : '' }}">
				                {!! Form::label('scheme_id', ucwords('scheme *'),['class'=>'control-label col-md-4']) !!}
				                <div class="col-md-8">
				                	<select class="form-control" name="scheme_id" id="scheme_id">
				                		@foreach($schemes as $scheme)
				                			<option value="{{ $scheme->id }}">{{ $scheme->name }}</option>
				                		@endforeach
				                	</select>
				                    {!! $errors->first('scheme_id', '<span class="help-block">:message</span>') !!}
				                </div>
				            </div>
                		</div>
                		<div class="col-sm-6">
                			<div class="form-group  {{ $errors->has('file') ? ' has-error' : '' }}">
				                {!! Form::label('file', ucwords('file *'),['class'=>'control-label col-md-4']) !!}
				                <div class="col-md-8">
			                		{{ Form::file('file', ['class' => 'form-control']) }}
				                    {!! $errors->first('file', '<span class="help-block">:message</span>') !!}
				                </div>
				            </div>
                		</div>
                		<div class="col-sm-2 col-sm-offset-10">
		                	<button class="btn btn-primary btn-flat"> <i class="fa fa-upload"></i> Upload</button>
	                	</div>
                	</div>

				{{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection