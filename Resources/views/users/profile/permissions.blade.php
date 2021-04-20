@extends("users::users.profile.partials._layout")

@section("heading", "User information")

@section("element")
<div class="col-md-12">
    {{--<h2 class="panel-title panel-guide"><i>{{ ucwords($user->roles()->first()->name) }}</i>--}}
        {{--<span class="text-success pull-right">Changes are saved automatically</span>--}}
    {{--</h2>--}}

    @foreach($groupedPermissions as $index => $groupPermissions)
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ ucwords($index) }} Module
            </div>
            <div class="panel-body">

                {{-- Resourceful permissions --}}
                @if(sizeof(resourceful($groupPermissions)))
                    <div class="row">
                        <div class="col-md-4">
                            <b>Resourceful Permissions</b>
                        </div>

                        @foreach($resources as $resource)
                            <div class="col-md-2">
                                <span>{{ $resource }}</span>
                            </div>
                        @endforeach

                        <hr>

                        <div style="margin-top: 10px">
                            @foreach(resourceful($groupPermissions) as $resource => $permissions)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <p>{{ ucwords($resource) }}</p>
                                        </div>

                                        @foreach($permissions as $permission)
                                            <div class="col-md-2">
                                                <input class="permission" type="checkbox" name="{{ $permission['name'] }}" @if($user->hasPermission($permission['name'])) {{ 'checked' }} @endif>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Special permissions --}}
                @if(sizeof(special($groupPermissions)) > 0)
                    <div class="row" style="margin-top: 15px">
                        <div class="col-md-4">
                            <b>Special Permissions</b>
                        </div>

                        <hr>

                        <div style="margin-top: 10px" class="row">
                            @foreach(special($groupPermissions) as $resource => $permission)
                                <div class="col-md-6">
                                    <div class="col-md-8">
                                        <p>{{ ucwords($permission['description']) }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="permission" type="checkbox" name="{{ $permission['name'] }}" @if($user->hasPermission($permission['name'])) {{ 'checked' }} @endif />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<style>
    .form-horizontal .control-label {
        text-align: left !important; /* !important added for priority in SO snippet. */
        font-weight: 400 !important;
    }

    .panel-borderless {
        border: 0;
        box-shadow: none;
    }
</style>
@stop

@section('scripts')
    <script type="text/javascript">

        //Save a permission on check
        $("body").on("change", '.permission', function(){

            $.post("{{ route('api.users.update', $user->id) }}", {
                permission: $(this).attr("name")
            });
        });
    </script>
@stop