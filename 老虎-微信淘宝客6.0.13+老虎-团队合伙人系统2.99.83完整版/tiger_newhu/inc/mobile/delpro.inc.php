<?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];

        exit(json_encode(array('error' =>2)));//暂停功能

        if($cfg['miyao']!=$_GPC['miyao']){
          exit(json_encode(array('error' =>2)));
        }
       
        $num_iid=$_GPC['num_iid'];
        if(empty($num_iid)){
          $msg=urlencode('商品已经被删除');
          exit(urldecode(json_encode(array('msg' => $msg))));
        }else{
          pdo_delete($this->modulename."_tbgoods", array('num_iid' => $num_iid));
          $msg=urlencode('删除商品成功，商品ID：'.$num_iid);
          exit(urldecode(json_encode(array('msg' => $msg))));
        }    
?>