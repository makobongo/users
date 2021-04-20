@extends('layouts.app')

@section('content_title', ucwords($role->name))
@section('content_description', $role->description)

@section('content')

    @foreach($groupedPermissions as $index => $groupPermissions)
        <div class="tw-w-full tw-bg-white tw-p-5 tw-mb-5 tw-border tw-border-solid tw-border-gray-300 tw-shadow tw-rounded">
            <div class="tw-text-2xl"><strong>{{ ucwords($index) }} Module</strong></div>
            
            <div class="tw-mt-5">
    
                {{-- Resourceful permissions --}}
                @if(sizeof(resourceful($groupPermissions)))
                    <div class="tw-flex">
                        <div class="tw-w-4/12">
                            <strong>Resourceful Permissions</strong>
                        </div>
    
                        @foreach($resources as $resource)
                            <div class="tw-w-2/12">
                                <span>{{ $resource }}</span>
                            </div>
                        @endforeach
                    </div>
        
                    <hr>
                
                    <div class="tw-mt-2">
                        @foreach(resourceful($groupPermissions) as $resource => $permissions)
                            <div class="tw-flex">
                                <div class="tw-w-4/12">
                                    <p>{{ ucwords($resource) }}</p>
                                </div>
                
                                @foreach($permissions as $permission)
                                    <div class="tw-w-2/12">
                                        <input class="permission" type="checkbox" name="{{ $permission['name'] }}" @if($role->hasPermission($permission['name'])) {{ 'checked' }} @endif>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
        
                @endif
    
                {{-- Special permissions --}}
                @if(sizeof(special($groupPermissions)) > 0)
                    <div class="row" style="margin-top: 15px">
                        <div class="col-md-4">
                            <b>Special Permissions</b>
                        </div>
            
                        <hr>
            
                        <div style="margin-top: 10px">
                            @foreach(special($groupPermissions) as $resource => $permission)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <p>{{ ucwords($permission['description']) }}</p>
                                        </div>
                            
                                        <div class="col-md-2">
                                            <input class="permission" type="checkbox" name="{{ $permission['name'] }}" @if($role->hasPermission($permission['name'])) {{ 'checked' }} @endif />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
    @endforeach

    <script type="text/javascript">

        $(document).ready(function () {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'excel', 'pdf'
                ]
            });

            $('.permission').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                increaseArea: '20%'
            });

            //Save a permission on check
            $('.permission').on("ifChanged", function() {

                $.post("{{ route('api.users.role.update', $role->id) }}", {
                    permission: $(this).attr("name")
                });

                    // function(data, status){
                    //     alert("Data: " + data + "\nStatus: " + status);
                    // });
            });
        });
    </script>
@stop
