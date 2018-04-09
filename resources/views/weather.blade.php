@extends ('home')
@section ('content')

    <h1 class="text-center">Actual Weather in Warsaw</h1>
    <div class="col col-sm-8">
        <div class="card text-center" style="background-color: #ffc107; color: black; weight: bold;">
            <div class="card-body">
                <i class="alert alert-info wi wi-day-{{ $icon }} display-4" style=" margin-bottom: 45px;"></i>
                <h2 class="card-title display-4">{{ $weathers->temperature }} &deg;C</h5>
                <hr>    
                <div class="card-text">
                    <h4 class="alert alert-info">Wind</h4>
                    <div class="row justify-content-center">
                        <div class="col col-sm-4">
                            {{ $weathers->wind }} km/h
                        </div>
                        <div class="col col-sm-4">
                            <i class="wi wi-wind towards-{{ $weathers->wind_dir }}-deg"></i>
                            &deg;
                        </div>
                    </div>
                    <hr>
                    <h4 class="alert alert-info">Humidity</h4>
                    <div class="row">
                        <div class="col col-sm-12">{{ $weathers->humidity }} %</div> 
                    </div>
                    <hr>
                    <h4 class="alert alert-info">Pressure</h4>
                    <div class="row">
                        <div class="col col-sm-12">{{ $weathers->pressure }} hPa</div> 
                    </div>
                    <hr>
                </div>
                <a href="/" class="btn btn-primary">Refresh</a>
                <p>Last refresh {{ date('H:i',strtotime($weathers->created_at)) }} </p>
            </div>
        </div>        
    </div>   
    
@endsection