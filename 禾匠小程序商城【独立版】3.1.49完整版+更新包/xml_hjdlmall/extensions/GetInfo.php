<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 13:38
 */

namespace app\extensions;


class getInfo
{
    //获取视频播放地址
    public static function getVideoInfo($url)
    {
//        $url = "https://v.qq.com/x/page/c0025lmctmo.html";
        preg_match("/\/([0-9a-zA-Z]+).html/", $url, $match);
        if (empty($match)) {
            return [
                'code' => 0,
                'msg' => 'success',
                'url' => $url
            ];
        }
        $vid = $match[1];//视频ID
        try {
            set_time_limit(0);
            $getinfo = "http://vv.video.qq.com/getinfo?vids={$vid}&platform=11&charge=0&otype=xml";
            $info = self::normal_curl($getinfo);
            $info_arr = self::xmlToArray($info);
            if ($info_arr['msg'] == 'vid is wrong') {
                return [
                    'code' => 1,
                    'msg' => '视频出错',
                    'url' => $url
                ];
            }
            $fi = $info_arr['fl']['fi'];
//            if(isset($fi[1])){
//                $format_id = $fi[1]['id'];
//                $fmt = $fi[1]['name'];
//                $format = 'p'.substr($format_id,-3,3);
//                $key = $info_arr['vl']['vi']['fvkey'];
//                $vid = $info_arr['vl']['vi']['vid'];
//                $url = $info_arr['vl']['vi']['ul']['ui'][0]['url'];
//                if(strlen($format_id)>=5){
//                    $mp4 = $vid.'.'.$format.'.1.mp4';
//                }else{
//                    $mp4 = $vid.'.mp4';
//                }
//                $video_url = $url . $mp4 .'?vkey='.$key.'&fmt='.$fmt;
//
//            }else{
                $getinfo = "http://vv.video.qq.com/getinfo?vids={$vid}&platform=101001&charge=0&otype=xml";
                $info = self::normal_curl($getinfo);
                $info_arr = self::xmlToArray($info);
                if (isset($info_arr['msg']) && $info_arr['msg'] == 'vid is wrong') {
                    return [
                        'code' => 0,
                        'msg' => '视频出错',
                        'url' => $url
                    ];
                }
                $filename = $info_arr['vl']['vi']['fn'];
                $key = $info_arr['vl']['vi']['fvkey'];
                $url = $info_arr['vl']['vi']['ul']['ui'][0]['url'];
                $video_url = $url . $filename . '?vkey=' . $key;
//            }
            return [
                'code' => 0,
                'msg' => 'success',
                'url' => $video_url
            ];

        } catch (\Exception $e) {
            return [
                'code' => 0,
                'msg' => 'success',
                'url' => $url
            ];
        }
    }

    //http网址访问
    public static function normal_curl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        //错误提示
        if (curl_exec($curl) === false) {
            die(curl_error($curl));
        }
        // 检查是否有错误发生
        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }

    //https网址访问
    public static function getHTTPS($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //将XML转为array
    public static function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}