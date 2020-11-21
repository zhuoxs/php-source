<?php
global $_W, $_GPC;
$dwz=$this->zydwz(urldecode($_GPC['url']));
$url="http://qr.liantu.com/api.php?m=10&w=200&text=".urlencode($dwz);

//$url=urldecode($_GPC['url']);  
$msg = curl_url($url,2);  
//Array ( [code] => 2101 [status] => error [msg] => url地址不正确! )
//exit(json_encode($msg));
exit(json_encode($msg['data']));
function curl_url($url,$type=0,$timeout=30){        
    $msg = ['code'=>2100,'status'=>'error','msg'=>'未知错误！'];  
    $imgs= ['image/jpeg'=>'jpeg',  
               'image/jpg'=>'jpg',  
               'image/gif'=>'gif',  
               'image/png'=>'png',  
               'text/html'=>'html',  
               'text/plain'=>'txt',  
               'image/pjpeg'=>'jpg',  
               'image/x-png'=>'png',  
               'image/x-icon'=>'ico'  
         ];  
    if(!stristr($url,'http')){  
        $msg['code']= 2101;  
        $msg['msg'] = 'url地址不正确!';    
        return $msg;  
    }     
    $dir= pathinfo($url);  
    //var_dump($dir);  
    $host = $dir['dirname'];  
    $refer= $host.'/';  
    $ch = curl_init($url);  
    curl_setopt ($ch, CURLOPT_REFERER, $refer); //伪造来源地址  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回变量内容还是直接输出字符串,0输出,1返回内容  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);//在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出  
    curl_setopt($ch, CURLOPT_HEADER, 0); //是否输出HEADER头信息 0否1是  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); //超时时间  
    $data = curl_exec($ch);  
    //$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);   
    //$httpContentType = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);  
    $info = curl_getinfo($ch);  
    curl_close($ch);  
    $httpCode = intval($info['http_code']);  
    $httpContentType = $info['content_type'];  
    $httpSizeDownload= intval($info['size_download']);  
      
    if($httpCode!='200'){  
        $msg['code']= 2102;  
        $msg['msg'] = 'url返回内容不正确！';  
        return $msg;  
    }  
    if($type>0 && !isset($imgs[$httpContentType])){  
        $msg['code']= 2103;  
        $msg['msg'] = 'url资源类型未知！';  
        return $msg;  
    }  
    if($httpSizeDownload<1){  
        $msg['code']= 2104;  
        $msg['msg'] = '内容大小不正确！';  
        return $msg;  
    }  
    $msg['code']  = 200;  
    $msg['status']='success';  
     $msg['msg']   = '资源获取成功';  
    if($type==0 or $httpContentType=='text/html') $msg['data'] = $data;  
    $base_64 = base64_encode($data);  
    if($type==1) $msg['data'] = $base_64;  
    elseif($type==2) $msg['data'] = "data:{$httpContentType};base64,{$base_64}";  
    elseif($type==3) $msg['data'] = "<img src='data:{$httpContentType};base64,{$base_64}' />";  
    else $msg['msg'] = '未知返回需求！';     
    unset($info,$data,$base_64);  
    return $msg;  
  
}  


?>
