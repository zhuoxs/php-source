<?php
  global $_W, $_GPC;
       $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
          exit('密钥错误，请检测秘钥，或更新缓存！');
        }
       $url=urldecode($_GPC['url']);//链接
       $img=urldecode($_GPC['img']);//图片地址
       $tjcontent=urldecode($_GPC['tjcontent']);//推荐内容    
      $taokouling=$this->tkl($url,$img,$tjcontent);
      $taokou=$taokouling->model;
      settype($taokou, 'string');
      exit($taokou);
      
?>