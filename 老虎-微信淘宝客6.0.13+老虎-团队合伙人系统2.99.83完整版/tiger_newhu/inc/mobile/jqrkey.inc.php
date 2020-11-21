<?php
global $_W, $_GPC;
         $cfg = $this->module['config'];
         $str=urldecode(trim($_GPC['str']));
         $pid=$_GPC['pid'];
         
         if(!empty($pid)){
           $pidSplit=explode('_',$pid);
           $cfg['siteid']=$pidSplit[2];
           $cfg['adzoneid']=$pidSplit[3];
           $cfg['ptpid']=$pid;
           $cfg['qqpid']=$pid;
         }
				 //关键词查询
				 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>1,'pid'=>$pid,'pic_url'=>'')));
				 $ddwz=$this->dwzw($tturl);
				 $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsgjqr']);
				 $newmsg=str_replace('#名称#',$str, $newmsg);
				 $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
				 //$newmsg=str_replace('#二维码图片#',$url, $newmsg);
				 exit($newmsg);
         
?>