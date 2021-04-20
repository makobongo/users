@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")
    
    {{ Form::model($user, ['method'=>'patch', 'url'=>route('users.update', $user->id), 'class' => 'form-horizontal']) }}

        <h2 class="tw-text-gray-600 tw-text-xl tw-text-center">Profile Details</h2>
    
        <div class="tw-flex tw-flex-wrap tw-p-2">
            <div class="tw-w-1/3 tw-text-right tw-pr-4">
                {!! Form::label('name', 'Title',['class'=>'control-label']) !!}
            </div>
            <div class="tw-w-2/3">
                {!! Form::select('profile[title]', mconfig('users.users.titles') , old('profile.title'), ['class' => 'form-control',]) !!}
                {!! $errors->first('profile.title', '<span class="help-block">:message</span>') !!}
            </div>
            
            <div class="tw-w-full tw-my-2"></div>
            
            <div class="tw-w-1/3 tw-text-right tw-pr-4">
                {!! Form::label('name', 'First Name',['class'=>'control-label']) !!}
            </div>
            <div class="tw-w-2/3">
                {!! Form::text('profile[first_name]', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                {!! $errors->first('profile.first_name', '<span class="help-block">:message</span>') !!}
            </div>
    
            <div class="tw-w-full tw-my-2"></div>
    
            <div class="tw-w-1/3 tw-text-right tw-pr-4">
                {!! Form::label('name', 'Last Name',['class'=>'control-label']) !!}
            </div>
            <div class="tw-w-2/3">
                {!! Form::text('profile[last_name]', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                {!! $errors->first('profile.last_name', '<span class="help-block">:message</span>') !!}
            </div>
    
            <div class="tw-w-full tw-my-2"></div>
    
            <div class="tw-w-1/3 tw-text-right tw-pr-4">
                {!! Form::label('id_number', 'ID Number', ['class'=>'control-label']) !!}
            </div>
            <div class="tw-w-2/3">
                {!! Form::number('profile[id_number]', old('id_number'), ['class' => 'form-control', 'placeholder' => 'ID Number']) !!}
                {!! $errors->first('profile.id_number', '<span class="help-block">:message</span>') !!}
            </div>
    
            <div class="tw-w-full tw-my-2"></div>
    
            <div class="tw-w-1/3 tw-text-right tw-pr-4">
                {!! Form::label('tel', 'Phone number',['class'=>'control-label']) !!}
            </div>
            <div class="tw-w-2/3">
                {!! Form::text('profile[phone]', old('phone'), ['class' => 'form-control', 'placeholder' => 'Phone No.']) !!}
                {!! $errors->first('profile.phone', '<span class="help-block">:message</span>') !!}
            </div>
            
            @if(m_setting('users.enable_check_roll_number'))
                <div class="tw-w-full tw-my-2"></div>
            
                <div class="tw-w-1/3 tw-text-right tw-pr-4">
                    {!! Form::label('roll_no', 'Check-Roll No.',['class'=>'control-label']) !!}
                </div>
                <div class="tw-w-2/3">
                    {!! Form::text('profile[roll_no]', old('roll_no'), ['class' => 'form-control', 'placeholder' => 'Check-Roll No.']) !!}
                    {!! $errors->first('profile.roll_no', '<span class="help-block">:message</span>') !!}
                </div>
            @endif
        </div>

        <button class="btn btn-success tw-ml-10">Update Details</button>

    {{ Form::close() }}

</div>

<style>
    form .tw-flex > div {
        margin-bottom: 20px;
    }
</style>

<script>
    $(document).ready(function () {
        $(".roles-selection").select2({
            theme: "bootstrap"
        });
    });
</script>
@stop
