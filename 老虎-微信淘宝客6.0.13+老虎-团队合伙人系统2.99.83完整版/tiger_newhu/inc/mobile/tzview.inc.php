<?php
  global $_W, $_GPC;
       $url=urldecode($_GPC['link']);
       $goodsid=$_GPC['goodsid'];
       $price=$_GPC['price'];
       $man=$_GPC['man'];

       if(!empty($goodsid)){
         $views=pdo_fetch("select * from".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and id='{$goodsid}'");
       }else{
         echo '商品不存在，已删除！';
         exit;
       }
       $cfg = $this->module['config'];
       $taokouling=$this->tkl($url,$views['pictUrl'],$views['title']);
       $taokou=$taokouling->model;
       settype($taokou, 'string');
       $taokouling=$taokou;
       
       include $this->template ('/tbgoods/style9/tzview');
?>