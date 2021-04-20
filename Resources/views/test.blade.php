@if(! is_null($result) )

    <h2>is not null</h2>
<ul>
    @foreach( $result as $item)

        <li>{{print_r($item)}}</li>

        @endforeach
</ul>
@endif