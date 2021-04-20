@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")
    @php
        $userClinics = $user->clinics()->get()->pluck('id')->toArray();
    @endphp

    <div class="container">
        <div class="col-md-12">
            <h2 class="panel-title panel-guide">User authorised clinics</h2>

            <div class="panel-body">

                {{ Form::model($user, ['method'=>'patch', 'url'=>route('users.update', $user->id), 'class' => 'form-horizontal']) }}

                @foreach(get_clinics() as $clinic)
                    <div class="form-group {{ $errors->has('user.username') ? ' has-error' : '' }}">
                        <label for="clinic-{{ $clinic->id }}" class="checkbox">
                            <input type="checkbox" name="clinics[]" value="{{ $clinic->id }}" id="clinic-{{ $clinic->id }}" {{ in_array($clinic->id, $userClinics) ? 'checked' : '' }}>
                            {{ $clinic->name }}
                        </label>
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-md-12" style="margin-top: 30px">
                        <button class="btn btn-success">Save clinics</button>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>

<style>
    .form-horizontal .control-label {
        text-align: left !important; /* !important added for priority in SO snippet. */
        font-weight: 400 !important;
    }
</style>

@stop