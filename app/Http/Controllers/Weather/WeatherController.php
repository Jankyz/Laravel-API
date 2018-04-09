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
        
        if ( !$weather ) {
            $this->storeWeather();
        } else {
            $now = (new DateTime())->format('Y-m-d G:i:s');
    
            $fromTime = strtotime($weather->created_at);
            $toTime = strtotime($now);
    
            $min = round(abs($toTime - $fromTime) / 60, 2);
            
            if ($min >= 60) {
                $this->storeWeather();
            }
        }
        
        $weathers = Weather::latest()->first();

        $icon = $this->getIconWeather($weathers->icon);

        return view('weather')
            ->with('weathers', $weathers)
            ->with('icon', $icon);

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
        $weather->wind_dir = $data['wind']['deg'];
        $weather->humidity = $data['main']['humidity'];
        $weather->pressure = $data['main']['pressure'];
        $weather->icon = $data['weather']['0']['id'];
        $weather->save();    
    }

    public function getIconWeather($icon)
    {
        switch ($icon) {
            case 200 : return 'lightning'; break;
            case 201 : return 'lightning'; break;
            case 202 : return 'lightning'; break;
            case 210 : return 'lightning'; break;
            case 211 : return 'lightning'; break;
            case 212 : return 'lightning'; break;
            case 221 : return 'lightning'; break;
            case 230 : return 'lightning'; break;
            case 231 : return 'lightning'; break;
            case 232 : return 'lightning'; break;
            case 300 : return 'showers'; break;
            case 301 : return 'showers'; break;
            case 302 : return 'showers'; break;
            case 310 : return 'showers'; break;
            case 311 : return 'showers'; break;
            case 312 : return 'showers'; break;
            case 321 : return 'showers'; break;
            case 500 : return 'rain'; break;
            case 501 : return 'rain'; break;
            case 502 : return 'rain'; break;
            case 503 : return 'rain'; break;
            case 504 : return 'rain'; break;
            case 511 : return 'sleet'; break;
            case 520 : return 'rain'; break;
            case 521 : return 'rain'; break;
            case 522 : return 'rain'; break;
            case 600 : return 'snow'; break;
            case 601 : return 'snow'; break;
            case 602 : return 'snow'; break;
            case 611 : return 'snow'; break;
            case 621 : return 'snow'; break;
            case 622 : return 'snow'; break;
            case 701 : return 'fog'; break;
            case 711 : return 'fog'; break;
            case 721 : return 'haze'; break;
            case 741 : return 'fog'; break;
            case 800 : return 'sunny'; break;
            case 801 : return 'cloudy'; break;
            case 802 : return 'cloudy'; break;
            case 803 : return 'cloudy'; break;
            case 804 : return 'sunny-overcast'; break;
        }
    }

}
