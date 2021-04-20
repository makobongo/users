@if($user->dependants->count()>0)
    <table class="data-table table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Names</th>
                <th>Relationship</th>
                <th>Date of Birth</th>
                <th>Age (Years)</th>
                <th>Image</th>
                <th data-sortable="false">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dependants as $d)
                <tr>
                    <td title="Dependant ID: {{ $d->id }}">{{ $loop->iteration }}</td>
                    <td>{{ $d->first_name }} {{ $d->last_name }}</td>
                    <td>{{ucfirst($d->relationship)}}</td>
                    <td>{{$d->dob}}</td>
                    <td>
                        @if((new Date($d->dob))->diff(Carbon\Carbon::now())->format('%y')>16)
                            {{(new Date($d->dob))->diff(Carbon\Carbon::now())->format('%y')}}
                            @if($d->relationship != 'spouse')
                                <i class="fa fa-warning" style="color: red"></i>
                            @else
                                <i class="fa fa-check" style="color: green"></i>
                            @endif
                        @else
                            {{(new Date($d->dob))->diff(Carbon\Carbon::now())->format('%y')}}
                            <i class="fa fa-check" style="color: green"></i>
                        @endif
                    </td>
                    <td>
                        <img src="{{ $d->image }}" class="img-responsive" style="max-height: 40px;">
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('users.dependants', ["id"=>$d->id,"user"=>$user->id]) }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ route('users.dependant.delete', [$d->id]) }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No dependants have been added so far for the employee.</p>
@endif