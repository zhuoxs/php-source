<?php
 global $_W, $_GPC;

        $cfg = $this->module['config'];
        if($cfg['miyao']!=$_GPC['miyao']){
          exit(json_encode(array('error' =>2)));
        }
       
        $id=$_GPC['id'];
        if(!empty($id)){
          if (pdo_update($this->modulename . "_tbgoodsqf", array('qfzt'=>1), array ('id' => $id)) === false) {
			 exit(urldecode(json_encode(array('msg' =>urlencode('更新失败')))));
		  }else{
             exit(urldecode(json_encode(array('msg' => urlencode("商品ID：".$id."已群发")))));
          }
        }else{
          exit(urldecode(json_encode(array('msg' =>urlencode('ID必须填写')))));
        }    
?>