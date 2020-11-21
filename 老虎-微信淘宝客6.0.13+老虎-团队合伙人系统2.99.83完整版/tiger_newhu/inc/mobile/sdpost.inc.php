<?php
 global $_W, $_GPC;
 $dluid=$_GPC['dluid'];//share id
 $order=$_GPC['order'];
 
       $dd =pdo_fetch("select * from ".tablename($this->modulename."_sdorder")." where weid='{$_W['uniacid']}' and `order`='{$order}' ");
       if(!empty($dd)){
         die(json_encode(array("status"=>10,'info'=>'订单号已经存在，不能重复提交!')));
       }

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }
       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($_GPC),FILE_APPEND);
       $img=array();
       foreach($_GPC['img'] as $k=>$v){
            $img[$k]=$this->apUpload($v);
       }
       $img = serialize($img);
        $data=array(
            'weid'=>$_W['uniacid'],
            'nickname'=>$fans['nickname'],
            'avatar'=>$fans['avatar'],
            'openid'=>$fans['openid'],
             'pf'=>$_GPC['grade'],//评分
             'order'=>$_GPC['order'],//订单号
             'evaluation'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC['evaluation']),ENT_QUOTES),//评论内容
             'price'=>$_GPC['price'],//到手价格
             'image'=>$img,//晒图多个图片
             'createtime'=>TIMESTAMP            
        );
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($data),FILE_APPEND);

        if(pdo_insert ($this->modulename . "_sdorder", $data)){
             die(json_encode(array("status"=>1,'info'=>'晒单成功')));
        }else{
             die(json_encode(array("status"=>10,'info'=>'系统繁忙，请稍后在试!')));
        }  