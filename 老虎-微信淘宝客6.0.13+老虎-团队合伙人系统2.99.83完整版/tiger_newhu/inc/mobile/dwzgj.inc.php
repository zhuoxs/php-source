<?php
	   //http://www.huurl.cn/app/index.php?i=3&c=entry&do=dwzgj&m=tiger_newhu&tkl=&rhyurl=http%3a%2f%2ftool.chinaz.com%2ftools%2funicode.aspx
       global $_W, $_GPC;
//     $tkl=urldecode($_GPC['tkl']);
//     $rhyurl=urldecode($_GPC['rhyurl']);
//     $picurl=urldecode($_GPC['picurl']);
       //$rhyurl=$_GPC['rhyurl'];
       $rhyurl=str_replace("\/","/",$_GPC['rhyurl']);
       
       $itemid=$_GPC['itemid'];
       $itempic=$_GPC['itempic'];
       $itemtitle=$_GPC['itemtitle'];
       $itemendprice=$_GPC['itemendprice'];
       $couponmoney=$_GPC['couponmoney'];
       $itemprice=$_GPC['itemprice'];
       $tkl=$_GPC['tkl'];
       //$rhyurl=$_GPC['rhyurl'];
        
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
          exit('error');
        }
       //echo $tkl;
        
        $urla=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tklview'))."&itemid=".$itemid."&itemendprice=".$itemendprice."&itemendprice=".$itemendprice."&couponmoney=".$couponmoney."&itemprice=".$itemprice."&tkl=".$tkl."&rhyurl=".$rhyurl."&itemtitle".$itemtitle."&itempic=".$itempic;
        $ddwz=$this->dwzw($urla);

        exit($ddwz);
?>