<?php
 global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id

       if(empty($_GPC['uid'])){
       	 die(json_encode(array("error"=>1,'info'=>'请先登录')));
       }
       
       $goodsid=$_GPC['itemid'];
       $scgoods = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_shoucang") . " WHERE weid = '{$_W['uniacid']}' and uid='{$_GPC['uid']}' and goodsid='{$goodsid}'");
       
	   if($_GPC['del']==1){
	   	 if($goodsid){
	   	 	pdo_delete($this->modulename."_shoucang", array('id' =>$scgoods['id']));
	   	 }
	   	 die(json_encode(array("error"=>0,'info'=>'成功'))); 	
	   }
       

        $data=array(
            'weid'=>$_W['uniacid'],
            'title'=>$_GPC['title'],
            'goodsid'=>$_GPC['itemid'],
            'picurl'=>$_GPC['pic_url'],
             'openid'=>$_GPC['openid'],             
             'itemendprice'=>$_GPC['itemendprice'],
             'itemprice'=>$_GPC['itemprice'],
             'itemsale'=>$_GPC['itemsale'],
             'couponmoney'=>$_GPC['couponmoney'],
             'rate'=>$_GPC['rate'],
             'tkl'=>$_GPC['tkl'],
             'uid'=>$_GPC['uid'],          
             'createtime'=>TIMESTAMP            
        );
        
        
        if(empty($scgoods)){
            if(pdo_insert ($this->modulename . "_shoucang", $data)){
                 die(json_encode(array("error"=>0,'info'=>'成功')));
            }        
        }else{
           pdo_delete($this->modulename."_shoucang", array('id' => $scgoods['id']));
            die(json_encode(array("error"=>0,'info'=>'成功')));
        }

        