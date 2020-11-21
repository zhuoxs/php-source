<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/3/11 0011
 * Time: 上午 11:34
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
class Weather_KundianFarmModel{
    public $uniacid='';
    static $common='';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
        self::$common=new Common_KundianFarmModel();
    }

    public function getTodayWeather(){
        $wxSetData=pdo_get('cqkundian_farm_wx_set',['uniacid'=>$this->uniacid],['longitude','latitude','appcode']);
        if(cache_load('kundian_farm_weather'.$this->uniacid)){
            //如果当前时间大于缓存时间,重新获取数据进行缓存
            if(cache_load('kundian_farm_weather_time'.$this->uniacid)+1800 > time()){
                $weather =  cache_load('kundian_farm_weather'.$this->uniacid);
                return ['weather'=>$weather,'weatherSet'=>$wxSetData];
            }
        }

        $farm_name=pdo_get('cqkundian_farm_about',['uniacid'=>$this->uniacid],'farm_name');
        $host = "https://api.caiyunapp.com/v2/" . $wxSetData['appcode'] . "/" . $wxSetData['longitude'].','.$wxSetData['latitude'] . "/realtime.json";
        $weather=$this->httpUrl($host);

        if ($weather->status == 'ok') {
            $data=$this->skyIcon($weather->result->skycon);
            $data['farm_name']=$farm_name['farm_name'];
            $data['skycon'] = $weather->result->skycon;
            $data['temperature'] = number_format($weather->result->temperature);
            $data['pm25'] = $weather->result->pm25;
            $data['cloudrate'] = $weather->result->cloudrate;
            $data['humidity'] = $weather->result->humidity*100;
            $data['cloudrate'] = $weather->result->cloudrate;
            $data['wind'] = $this->getWindSpeed($weather->result->wind->speed);
            $data['aqi']=$this->aqiText($weather->result->aqi);

            $yubao=$this->getPrediction($wxSetData['appcode'],$wxSetData['longitude'].','.$wxSetData['latitude']);
            $data['hourly_data']=$yubao['hourly_data'];
            $data['daily_data']=$yubao['daily_data'];
            $data['hourly_description']=$yubao['hourly_description'];
            $data['forecast_keypoint']=$yubao['forecast_keypoint'];
            $data['date']=date("Y年m月d日",time());

            $today=[
                [
                    'day'=>'今天',
                    'aqi'=> $data['daily_data'][0]['aqi'],
                    'skyDesc'=>$data['skyDesc'],
                    'temp_min'=>$data['daily_data'][0]['min'],
                    'temp_max'=>$data['daily_data'][0]['max'],
                    'img'=>$data['daily_data'][0]['img'],
                ],
                [
                    'day'=>'明天',
                    'aqi'=> $data['daily_data'][1]['aqi'],
                    'skyDesc'=>$data['daily_data'][1]['skyDesc'],
                    'temp_min'=>$data['daily_data'][1]['min'],
                    'temp_max'=>$data['daily_data'][1]['max'],
                    'img'=>$data['daily_data'][1]['img'],
                ],
            ];
            $data['today']=$today;
            cache_write('kundian_farm_weather'.$this->uniacid,$data);
            cache_write('kundian_farm_weather_time'.$this->uniacid,time());
            return  ['weather'=>$data,'weatherSet'=>$wxSetData];;
        }
    }

    /** 获取未来的天气预报 */
    public function getPrediction($appcode,$location){
        $host="http://api.caiyunapp.com/v2/$appcode/$location/weather.jsonp?dailysteps=15";
        $weather=$this->httpUrl($host);
        $hourly=$weather->result->hourly;
        $skycon=self::$common->objectToArray($hourly->skycon);
        $temperature=self::$common->objectToArray($hourly->temperature);
        $hourly_aqi=self::$common->objectToArray($hourly->aqi);
        $hourly_data=array();
        for ($i=0;$i<count($temperature);$i++){
            $hourly_data[$i]=$this->skyIcon($skycon[$i]['value']);
            $hourly_data[$i]['temp']=number_format($temperature[$i]['value']);
            $hourly_data[$i]['skycon']=$skycon[$i]['value'];
            $hourly_data[$i]['aqi']=$this->aqiText($hourly_aqi[$i]['value']);
            $hourly_data[$i]['datetime']=explode(" ",$temperature[$i]['datetime']);
        }

        $daily=$weather->result->daily;
        $daily_temperature=self::$common->objectToArray($daily->temperature);
        $daily_skycon=self::$common->objectToArray($daily->skycon);
        $daily_aqi=self::$common->objectToArray($daily->aqi);
        $daily_wind=self::$common->objectToArray($daily->wind);
        $daily_data=array();
        for ($i=0;$i<count($daily_temperature);$i++){
            $daily_data[$i]=$this->skyIcon($daily_skycon[$i]['value']);
            $daily_data[$i]['date']=date("m-d",strtotime($daily_temperature[$i]['date']));
            $daily_data[$i]['week']=$this->getWeek(date("w",strtotime($daily_temperature[$i]['date'])));
            $daily_data[$i]['max']=number_format($daily_temperature[$i]['max']);
            $daily_data[$i]['min']=number_format($daily_temperature[$i]['min']);
            $daily_data[$i]['skycon']=$daily_skycon[$i]['value'];
            $daily_data[$i]['aqi']=$this->aqiText($daily_aqi[$i]['avg']);
            $daily_data[$i]['wind']=$this->getWindSpeed($daily_wind[$i]['avg']['speed']);
            $daily_data[$i]['wind_direction']=$this->getWindDirection($daily_wind[$i]['avg']['direction']);
        }
        $return['hourly_data']=$hourly_data;
        $return['daily_data']=$daily_data;
        $return['hourly_description']=$hourly->description;
        $return['forecast_keypoint']=$weather->result->forecast_keypoint;
        return $return;
    }

    public function httpUrl($host){
        $method = "GET";
        $curl = curl_init();
        $headers = array();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($curl);
        $start = strpos($result, '{');
        $str = substr($result, $start);
        return json_decode($str);

    }

    public function skyIcon($skycon){
        global $_W;
        $root=$_W['siteroot'].'addons/kundian_farm/resource/img/skyicon/';
        switch ($skycon){
            case 'CLEAR_DAY':
                return [
                    'bg'=>$root.'bg_clear.jpg',
                    'img'=>$root.'clear.png',
                    'skyDesc'=>'晴'
                ];
                break;
            case 'CLEAR_NIGHT':
                return [
                    'bg'=>$root.'bg_clear_night.jpg',
                    'img'=>$root.'clear_night.png',
                    'skyDesc'=>'晴'
                ];
                break;
            case 'PARTLY_CLOUDY_DAY':
                return [
                    'bg'=>$root.'bg_partly_cloudy.jpg',
                    'img'=>$root.'partly_cloudy.png',
                    'skyDesc'=>'多云'
                ];
                break;
            case 'PARTLY_CLOUDY_NIGHT':
                return [
                    'bg'=>$root.'bg_partly_cloudy_night.jpg',
                    'img'=>$root.'partly_cloudy_night.png',
                    'skyDesc'=>'多云'
                ];
                break;
            case 'CLOUDY':
                return [
                    'bg'=>$root.'bg_cloudy.jpg',
                    'img'=>$root.'cloudy.png',
                    'skyDesc'=>'阴'
                ];
                break;
            case 'RAIN':
                return [
                    'bg'=>$root.'bg_rain.jpg',
                    'img'=>$root.'rain.png',
                    'skyDesc'=>'雨'
                ];
                break;
            case 'SNOW':
                return [
                    'bg'=>$root.'bg_snow.jpg',
                    'img'=>$root.'snow.png',
                    'skyDesc'=>'雪'
                ];
                break;
            case 'WIND':
                return [
                    'bg'=>$root.'bg_wind.jpg',
                    'img'=>$root.'wind.png',
                    'skyDesc'=>'风'
                ];
                break;
            case 'HAZE':
                return [
                    'bg'=>$root.'bg_fog.jpg',
                    'img'=>$root.'fog.png',
                    'skyDesc'=>'雾霾沙尘'
                ];
                break;
        }
    }

    /** 空气质量指数标准等级 */
    public function aqiText($aqi){
        global $_W;
        $root=$_W['siteroot'].'addons/kundian_farm/resource/img/skyicon/';
        if($aqi >= 0 && $aqi <= 50){
            return ['text'=>'优','value'=>$aqi,'color'=>'#35c7d1','icon'=>$root.'fresh.png'];
        }elseif($aqi>=51 && $aqi <=100){
            return ['text'=>'良','value'=>$aqi,'color'=>'#5ebb8d','icon'=>$root.'good.png'];
        }elseif($aqi>=101 && $aqi <=150){
            return ['text'=>'轻度','value'=>$aqi,'color'=>'#8bc500','icon'=>$root.'light.png'];
        }elseif($aqi>=151 && $aqi <=200){
            return ['text'=>'中度','value'=>$aqi,'color'=>'#e29b12','icon'=>$root.'light.png'];
        }elseif($aqi>=201 && $aqi <=300){
            return ['text'=>'重度','value'=>$aqi,'color'=>'#e06641','icon'=>$root.'heavy.png'];
        }elseif($aqi>300){
            return ['text'=>'严重','value'=>$aqi,'color'=>'#860022','icon'=>$root.'heavy.png'];
        }
    }

    public function getWindDirection($direction){
        if($direction >0 && $direction <=22.5){
            return '北风';
        }elseif ($direction >22.5 && $direction <=67.5){
            return '东北风';
        }elseif ($direction >22.5 && $direction <=67.5){

        }elseif ($direction >67.5 && $direction <=112.5){
            return '东风';
        }elseif ($direction >112.5 && $direction <=157.5){
            return '东南风';
        }elseif ($direction >157.5 && $direction <=202.5){
            return '南风';
        }elseif ($direction >202.5 && $direction <=247.5){
            return '西南风';
        }elseif ($direction >247.5 && $direction <=292.5){
            return '西风';
        }elseif ($direction >292.5 && $direction <=337.5){
            return '西北风';
        }elseif ($direction >337.5 && $direction <=360){
            return '北风';
        }
    }

    public function getWindSpeed($speed){
        if($speed < 1 ){
            return ['speed_text'=>'无风','speed_level'=>'0级'];
        }elseif ($speed >=1 && $speed <=5){
            return ['speed_text'=>'软风','speed_level'=>'1级'];
        }elseif ($speed >5 && $speed <=11){
            return ['speed_text'=>'轻风','speed_level'=>'2级'];
        }elseif ($speed > 12 && $speed <=19){
            return ['speed_text'=>'微风','speed_level'=>'3级'];
        }elseif ($speed>20 && $speed<=28){
            return ['speed_text'=>'和风','speed_level'=>'4级'];
        }elseif ($speed>29 && $speed <=38){
            return ['speed_text'=>'劲风','speed_level'=>'5级'];
        }elseif ($speed>39 && $speed<=49){
            return ['speed_text'=>'强风','speed_level'=>'6级'];
        }elseif ($speed > 50 && $speed <=61){
            return ['speed_text'=>'疾风','speed_level'=>'7级'];
        }elseif ($speed >62 && $speed<=74){
            return ['speed_text'=>'大风','speed_level'=>'8级'];
        }elseif ($speed >75 && $speed<=88){
            return ['speed_text'=>'烈风','speed_level'=>'9级'];
        }elseif ($speed >89 && $speed<=102){
            return ['speed_text'=>'狂风','speed_level'=>'10级'];
        }elseif ($speed >103 && $speed<=117){
            return ['speed_text'=>'暴风','speed_level'=>'11级'];
        }elseif ($speed >117 ){
            return ['speed_text'=>'飓风','speed_level'=>'12级'];
        }
    }

    public function getWeek($day){
        switch ($day){
            case 1:
                return "周一";
                break;
            case 2:
                return '周二';
                break;
            case 3:
                return '周三';
                break;
            case 4:
                return '周四';
                break;
            case 5:
                return '周五';
                break;
            case 6:
                return '周六';
                break;
            case 0:
                return '周日';
                break;
        }
    }

}