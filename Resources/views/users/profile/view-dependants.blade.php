@extends("users::users.profile.partials._layout")

@section("heading", "User dependants")

@section("element")

<div class="col-md-12">
    @if(permit("users.dependants.index"))
        <table id="table" class="table table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Relationship</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>More</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->dependants as $dependant)
                    <tr class="{{ $dependant->is_eligible ?: 'bg-danger' }}">
                        <td>{{ $dependant->full_name }}</td>
                        <td>{{ smart_date($dependant->dob) }} <small class="font-italic">({{ $dependant->age }} yrs)</small></td>
                        <td>{{ $dependant->relationship }}</td>
                        <td>{{ $dependant->gender }}</td>
                        <td>{{ $dependant->mobile }}</td>
                        <td>
                            @if($dependant->is_eligible)
                                <span class="text-success"><i class="fa fa-check"></i> Eligible for Treatment under cover</span>
                            @else
                                <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Not Eligible for Treatment under cover</span>
                            @endif

                            @if(permit("users.dependants.destroy"))
                                {{--<button class="btn btn-danger btn-xs">Remove</button>--}}
                            @endif
                        </td>
                    </tr>
                @empty

                @endforelse
            </tbody>
        </table>
    @else
        <p>Sorry! You do not have permission to perform this action.</p>
    @endif
</div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            try {
                $('#table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        // 'csv', 'excel',
                        // 'pdf', 'print'
                    ]
                });
            } catch (e) {

            }
        });
    </script>
@stop