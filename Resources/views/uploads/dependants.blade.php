@extends('layouts.app')

@section('content_title','Uploads Section')
@section('content_description','Upload Dependants from Excel Worksheet')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
            	Upload a valid Excel Worksheet containing a list of Dependants.
            </div>
            <!-- /.box-header -->

            <div class="box-body">
            	<h4 class=" title text-muted">Worksheet Headers</h4>
            	<table class="table">
            		<thead class="bg-primary">
            			<tr>
            				<th>Roll No. *</th>
            				<th>First Name *</th>
            				<th>Middle Name</th>
            				<th>Last Name *</th>
							<th>Date of Birth *</th>
							<th>Gender *</th>
            				<th>Relationship *</th>
            				<th>Mobile</th>
            			</tr>
            		</thead>
            	</table>
            	<hr/>

            	<h4 class=" title text-muted">Let's upload a worksheet</h4>
				{{ Form::open(['route' => 'users.upload.dependants.store', 'method' => 'post', 'files' => true, 'class' => 'form-horizontal']) }}
                	<div class="row">
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