<?php

namespace App\Http\Controllers\Weather;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Weather;
use DateTime;

class WeatherController extends Controller
{
    private $url;
    private $curl;
    private $data;

    public function weather()
    {
        $weather = Weather::latest()->first();
        $now = (new DateTime())->format('Y-m-d G:i:s');

        $fromTime = strtotime($weather->created_at);
        $toTime = strtotime($now);

        $min = round(abs($toTime - $fromTime) / 60, 2);

        
        echo $min;

        if ($min >= 60){
            $this->storeWeather();
        }
        $weathers = Weather::latest()->first();
        return view('weather')->with('weathers', $weathers);

    }
    

    public function storeWeather()
    {
        $url = 'http://api.openweathermap.org/data/2.5/weather?id=756135&units=metric&lang=pl&APPID=5238129a334225747f826bbf76c04ff1';
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $resp = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($resp, true);

        $weather = new Weather;
        $weather->temperature = $data['main']['temp'];
        $weather->wind = $data['wind']['speed'];
        $weather->humidity = $data['main']['humidity'];
        $weather->pressure = $data['main']['pressure'];
        $weather->save();    
    }

}
