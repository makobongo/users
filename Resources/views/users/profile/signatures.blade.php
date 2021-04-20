@extends("users::users.profile.partials._layout")

@section("element-styles")
    <style>
        .img-holder {
            width: 250px;
            height: 250px;
            background: #ececec;
        }
    </style>
@stop

@section('heading', 'Signatures')

@section("element")
    <div class="col-md-6">
        <h2 class="panel-title panel-guide">User Signature</h2>

        @if($user->signature)
            <img src="{{ $user->signature }}" alt="signature" class="img-fluid img-responsive mt-4">
        @else
            <div class="img-holder mt-4">
                <div class="py-4 pl-4">
                    Signature Not Set
                </div>
            </div>
        @endif
        
    </div>
    
    <div class="col-md-6">
        {{ Form::model($user, ['method'=>'patch', 'url'=>route('users.update', $user->id), 'class' => 'form-horizontal', 'files' => true]) }}
    
        <div class="form-group row req {{ $errors->has('profile.signature') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Signature', ['class'=>'control-label col-md-3']) !!}
            <div class="col-md-9">
                <input type="file" name="signature" class="form-input">
                {!! $errors->first('profile.signature', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12" style="margin-top: 30px">
                <button class="btn btn-success">Update user Signature</button>
            </div>
        </div>
    
        {{ Form::close() }}
        
    </div>
@stop
