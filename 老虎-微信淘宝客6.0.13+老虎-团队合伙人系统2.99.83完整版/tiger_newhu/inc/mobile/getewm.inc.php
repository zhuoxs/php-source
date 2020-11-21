<?php
  global $_W, $_GPC;
  $cfg = $this->module['config'];
  $dwz=zydwz(urldecode($_GPC['url']),$_W,$cfg);
  
  function zydwz($turl,$_W,$cfg){//自有短网址        
        $data=array(
                'weid'=>$_W['uniacid'],
                'url'=>$turl,
                'createtime'=>TIMESTAMP,
                );
        pdo_insert("tiger_newhu_dwz",$data);
        $id = pdo_insertid();        
        $url=$cfg['zydwz']."t.php?d=".$id;
        return $url;
    }
  
  function getermg($url,$path='',$_W){//二维码保存到指定分日期保存目录
        empty($path)&&($path = IA_ROOT."/addons/tiger_newhu/goodsimg/".date("Ymd"));
        !file_exists($path)&&mkdir ($path, 0777, true );
        if($url == "")return false;
        $sctime=date("YmdHis").sjrd44(6);
        $filename = $path.'/'.$sctime.".png";
        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
        $fp = fopen($filename, "a");
        fwrite($fp, $img);
        fclose($fp);
        //return $filename.'-----'."/addons/tiger_newhu/goodsimg/".$sctime.".jpg";//返回文件名
        return "/addons/tiger_newhu/goodsimg/".date("Ymd").'/'.$sctime.".png";//返回文件名
    }
    
  function sjrd44($length = 4){ 
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $str = ''; 
            for ($i = 0; $i<$length;$i++ ) 
            {  
                $str .= $chars[mt_rand(0, strlen($chars)-1)]; 
            } 
            return $str; 
        } 
     //$url="http://qr.liantu.com/api.php?m=10&w=200&text=".urlencode($dwz);
     //$url="http://bshare.optimix.asia/barCode?site=weixin&url=".urlencode($dwz);
     $url="http://qr.topscan.com/api.php?text=".urlencode($dwz);

     $ewm=getermg($url,'',$_W);

     exit(json_encode($ewm));
?>