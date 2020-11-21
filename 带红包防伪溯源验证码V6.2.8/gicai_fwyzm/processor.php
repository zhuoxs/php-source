<?php
/**
 * 计彩网络 爱驴微信平台 多活动模块DEMO
 * @1.0
 * @author gicai_fwyzm
 * @url http://www.ilvle.com/
 * @time 2017年12月9日17:03:23
 */
defined('IN_IA') or exit('Access Denied');

class gicai_fwyzmModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W, $_GPC;
		$rid = $this->rule;
		$fromuser = $this->message['from'];
		if ($rid) {
			$reply = cache_load('account:gicai_fwyzm_reply_r_'.$rid);
			if(!$reply){
				$reply = pdo_fetch("SELECT * FROM " . tablename("gicai_fwyzm_reply") . " WHERE rid = :rid", array(':rid' => $rid));
				cache_write('account:gicai_fwyzm_reply_r_'.$rid,$reply);
			}
			if($reply) {
				$activity = cache_load('account:gicai_fwyzm_f_'.$reply['fid'].'_u_'.$_W['uniacid']);
				if(!$activity){
					$sql = 'SELECT * FROM ' . tablename("gicai_fwyzm") . ' WHERE `uniacid`=:uniacid AND `id`=:fid';
                	$activity = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':fid' => $reply['fid']));
					cache_write('account:gicai_fwyzm_f_'.$reply['fid'].'_u_'.$_W['uniacid'],$activity);
				}
				$news = array();
				$scene = $this->message['scene'];
				if($_W['uniaccount']['level']==4){$fromuser='';}
				
				if($scene!='' && stripos($scene,"code_")!== false){
					$scene = str_replace("code_","",$scene);
				}else{
					$scene = '';	
				}
                $news[] = array(
                    'title' => $activity['title'],
                    'description' => trim(strip_tags($activity['description'])),
                    'picurl' => tomedia($activity['fmimg']),
                    'url' => $this->createmobileUrl('index',array('fid'=>$activity['id'],'openid'=>$fromuser,'codekey'=>$scene)),
                );
                return $this->respNews($news);
            }
        }
		
        return null;
		
		//$rid = $this->rule;
//		$content = $this->message['content'];
//		$type = $this->message['type'];
//		 
//		$fromuser = $this->message['from'];
//		return $this->respText('欢迎您 ： ' . $rid.$fromuser.$content.$type.$scene);
		
	}
}