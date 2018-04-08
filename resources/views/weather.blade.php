@extends ('home')
@section ('content')

<h1>Actual Weather in Warsaw</h1>
        <div>{{ $weathers->temperature }} C</div>
        <div>{{ $weathers->wind }} km/h</div> 
        <div>{{ $weathers->humidity }} %</div> 
        <div>{{ $weathers->pressure }} hPa</div> 
@endsection