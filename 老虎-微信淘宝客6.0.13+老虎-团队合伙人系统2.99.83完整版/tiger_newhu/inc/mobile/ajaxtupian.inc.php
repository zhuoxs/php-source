<?php
global $_GPC,$_W;
        $cfg = $this->module['config'];
        $itemid=$_GPC['itemid'];//商品ID
        $title =urlencode($_GPC['title']);//标题
        $price=$_GPC['price'];//券后价
        $yhj=$_GPC['yhj'].'元';//优惠券
        $orprice=$_GPC['orprice'].'元';//原价
        $xiaol='销量'.$_GPC['xiaol'];//销量
        $jrprice=$_GPC['price'];//券后价
        $viewurl=urlencode($_GPC['viewurl']);//商品链接
        $tkl=$_GPC['tkl'];//淘口令
		//$image = tomedia($backgro);	//http://cs.youqi18.com/attachment/qrcode_5.jpg
		$taoimage=$_GPC['pic_url']."_250x250.jpg";//商品图片
		$itempic=urlencode($taoimage);
        //$taoimage='https://gd2.alicdn.com/imgextra/i3/58671495/TB2P0orfCVmpuFjSZFFXXcZApXa_!!58671495.jpg';
        $rhyurl=urlencode($_GPC['rhyurl']);//二合一链接
        if(empty($rhyurl)){
        	exit(json_encode(array('status' => 2, 'content' =>'图片生成失败！','lm'=>1)));
        }
        
        //file_put_contents(IA_ROOT."/addons/tiger_taoke/inc/mobile/log.txt","\n".$viewurl,FILE_APPEND);
        
        
        if(empty($cfg['itemewm'])){
        	$url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openview'))."&link=".$rhyurl;
            $url=urlencode($url);
        }elseif($cfg['itemewm']==1){
        	$url=$viewurl;
        }elseif($cfg['itemewm']==2){
        	$url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tklview',array('itemid'=>$itemid,'itemendprice'=>$price,'couponmoney'=>$yhj,'itempic'=>$itempic,'tkl'=>$tkl,'itemprice'=>$_GPC['orprice'])))."&rhyurl=".$rhyurl."&itemtitle=".$title;
        	$url=urlencode($url);
        }
        
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


        $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tupian',$data));
        //die("<img src=".$tturl.">") ;
    	exit(json_encode(array('status' => 1, 'content' => $tturl,'lm'=>1)));
?>