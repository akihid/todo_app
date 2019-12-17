<?php

namespace App\Services;
use Carbon\Carbon;
use GuzzleHttp\Client;

class OpenWeatherMap
{
  private const SEARCH_API_URL = 'http://api.openweathermap.org/data/2.5/forecast?';

  public function getWeather($user): array
  {
    $client = new Client();
    $search_id = (empty($user->birthplace)) ?'1850147' : $user->birthplace_id;

    $res = $client->get(self::SEARCH_API_URL, [
                    'query' => [
                      'id' =>  $search_id,
                      'units' => 'metric',
                      'APPID' => env('OPEN_WEATHER_MAP_API_KEY'),
                    ]
                  ]);
    $data = json_decode($res->getBody(), true);
    $weather_list = $data['list'];
    
    foreach( $weather_list as $key => $items ){

      // 24時間分だけ取得する
      if ($key == 8){
        break;
      } 
    

      $array[$key]['temp'] = $items['main']['temp']; // 気温
      $array[$key]['humidity']  = $items['main']['humidity'];
      $array[$key]['weather'] = $items['weather'][0]['main'];
      $array[$key]['des'] = $this->getTranslation($items['weather'][0]['description']); 
      $array[$key]['icon'] = "http://openweathermap.org/img/wn/" .$items['weather'][0]['icon']. "@2x.png";
      
      $datetime = new Carbon();
      $datetime = $datetime->setTimestamp( $items['dt'] )->timezone('Asia/Tokyo');
      $array[$key]['date'] = $datetime->format('Y年m月d日'); // 日付
      $array[$key]['time'] = $datetime->format('H:i'); // 時間
    }

    return $array;
  }
  // 日本語に変換
  private function getTranslation($arg){
    switch ($arg) {
      case 'overcast clouds':
        return 'どんよりした雲<br class="nosp">（雲85~100%）';
        break;
      case 'broken clouds':
        return '千切れ雲<br class="nosp">（雲51~84%）';
        break;
      case 'scattered clouds':
        return '散らばった雲<br class="nosp">（雲25~50%）';
        break;
      case 'few clouds':
        return '少ない雲<br class="nosp">（雲11~25%）';
        break;
      case 'light rain':
        return '小雨';
        break;
      case 'moderate rain':
        return '雨';
        break;
      case 'heavy intensity rain':
        return '大雨';
        break;
      case 'very heavy rain':
        return '激しい大雨';
        break;
      case 'clear sky':
        return '快晴';
        break;
      case 'shower rain':
        return 'にわか雨';
        break;
      case 'light intensity shower rain':
        return '小雨のにわか雨';
        break;
      case 'heavy intensity shower rain':
        return '大雨のにわか雨';
        break;
      case 'thunderstorm':
        return '雷雨';
        break;
      case 'snow':
        return '雪';
        break;
      case 'light snow':
        return '軽い雪';
        break;
      case 'mist':
        return '靄';
        break;
      case 'tornado':
        return '強風';
        break;
      default:
        return $arg;
    }
  }
}