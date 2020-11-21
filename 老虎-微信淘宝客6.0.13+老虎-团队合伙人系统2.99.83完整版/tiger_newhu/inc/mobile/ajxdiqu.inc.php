<?php
 global $_W, $_GPC;
       $diqu=$_GPC['city'];
       $province=$_GPC['province'];
       $district=$_GPC['district'];
       $uid=$_GPC['uid'];
       $scene_id=$_GPC['scene_id'];//上级
       $from_user=$_GPC['from_user'];//当前用户openid
       $ddtype=$_GPC['ddtype'];
       $cfg=$this->module['config'];
       load()->model('mc');
       $fans=pdo_fetch('select * from '.tablename('mc_mapping_fans').' where uniacid=:uniacid and uid=:uid order by fanid asc limit 1',array(':uniacid'=>$_W['uniacid'],':uid'=>$uid));
       $user=mc_fetch($uid);
       $pos = stripos($cfg['city'],$diqu);


       if($ddtype==1){
          $nzmsg="抱歉!\n\n核对位置失败，请先开启共享位置功能！";
          $this->sendtext($nzmsg,$fans['openid']);
          exit;
       }
       if ($pos === false) {
         $nzmsg="抱歉!\n\n本次活动只针对【".$cfg['city']."】微信用户开放\n\n您所在的位置【".$diqu."】未开启活动，您不能参与本次活动，感谢您的支持!";
         mc_update($uid, array('resideprovince'=>$province,'residecity' =>$diqu,'residedist'=>$district));
       }else{
         mc_update($uid, array('resideprovince'=>$province,'residecity' =>$diqu,'residedist'=>$district));
         $nzmsg='位置核对成功，请点击菜单【生成海报】参加活动!';
       }

       $this->sendtext($nzmsg,$fans['openid']);
?>