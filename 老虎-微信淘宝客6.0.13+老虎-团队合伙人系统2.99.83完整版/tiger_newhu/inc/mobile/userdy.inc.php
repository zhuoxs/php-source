<?php
 global $_W, $_GPC;
       $cfg = $this->module['config'];
       if($_W['isajax']){
        	$id=$_GPC['uid'];
       	    $member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$id}'");
       	    if($member['dytype']==1){
       	    	  $data=array(
		               'dytype'=>0,
		           );
		          if(!empty($id)){
		            pdo_update($this->modulename."_share", $data, array('id' => $id));
		          }
		          exit(json_encode(array('statusCode' => 1,'msg'=>"订阅成功")));
       	    }else{
       	    	$data=array(
		               'dytype'=>1,
		           );
		          if(!empty($id)){
		            pdo_update($this->modulename."_share", $data, array('id' => $id));
		          }
		          exit(json_encode(array('statusCode' => 2,'msg'=>"已退订")));
       	    }
           
          
          
       }