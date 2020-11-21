<?php
global $_GPC,$_W;
        $cfg = $this->module['config'];
        $pid=$_GPC['pid'];
        $num_iid=$_GPC['num_iid'];
        $tkl=$_GPC['tkl'];
        $ehyurl=urlencode($_GPC['ehyurl']);
        $num_iid=$_GPC['num_iid'];
        $qun_id=$_GPC['qun_id'];
        $title =urlencode($_GPC['title']);//标题
        $price=$_GPC['price'];//券后价
        $yhj=$_GPC['yhj'];//优惠券
        $orprice=$_GPC['orprice'];//原价
        $xiaol=$_GPC['xiaol'];//销量
        $jrprice=$_GPC['price'];//券后价
        
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/tupia.txt","\n".$pid."--"."--".$title."--".$price."--".$yhj."--".$orprice."--".$jrprice,FILE_APPEND);
		//$image = tomedia($backgro);	//http://cs.youqi18.com/attachment/qrcode_5.jpg
         $taoimage=$_GPC['taoimage'];//'https://gd2.alicdn.com/imgextra/i3/58671495/TB2P0orfCVmpuFjSZFFXXcZApXa_!!58671495.jpg';
          //跳转链接http://cs.tigertaoke.com/app/index.php?i=2&c=entry&do=Openlink&m=tiger_newhu&link=http://www.baidu.com
         
         if($cfg['itemewm']==3){
         	$straaa=urlencode("请点击右下方复制按钮".$tkl."然后打开手机淘宝即可领券购买");
         	$urlaa="http://fanyi.baidu.com/?aldtype=16047#cht/zh/".$straaa;
         	$url=urlencode($urlaa);
         }else{
         	$url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('Openlink',array('link'=>$ehyurl)));
         }
         //$url=$tkl;
          
//        echo $url;
//        echo "<br>";
//        echo urldecode($url);
//        exit;

        $data=array(
          'title'=>$title,
          'price'=>$price,
          'yhj'=>$yhj,
          'orprice'=>$orprice,
          'xiaol'=>$xiaol,
          'jrprice'=>$jrprice,
          'taoimage'=>$taoimage,
          'url'=>$url        
        );
        
        //echo "<pre>";
        //	print_r($data);
        //	exit;


        $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tupian',$data));
        //die("<img src=".$tturl.">") ;
    	exit(json_encode(array('status' => 1, 'content' => $tturl,'lm'=>1)));
?>