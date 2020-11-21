<?php
class videoInfo

{

    public static function getVideoInfo($video)
    {

      $vid=trim(strrchr($video, '/'),'/');
      $vid=substr($vid,0,-5);
      $json=file_get_contents("http://vv.video.qq.com/getinfo?vids=".$vid."&platform=101001&charge=0&otype=json");
         // echo $json;die;
      $json=substr($json,13);
      $json=substr($json,0,-1);
      $a=json_decode(html_entity_decode($json));
      $sz=json_decode(json_encode($a),true);
      // var_dump($sz);exit;
         // print_R($sz);die;
      $url=$sz['vl']['vi']['0']['ul']['ui']['3']['url'];
      $fn=$sz['vl']['vi']['0']['fn'];
      $fvkey=$sz['vl']['vi']['0']['fvkey'];
      $url=$url.$fn.'?vkey='.$fvkey;
      return  $url;
    }

}