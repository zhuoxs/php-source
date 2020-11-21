<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
load()->func('tpl');
switch($_GPC['mo']) {
	case 'list':
		$kwd = $_GPC['keyword'];
       	$vote_s = "SELECT * FROM " .tablename('gicai_fwyzm')."WHERE `uniacid`=:uniacid and `title` LIKE '%{$kwd}%'";
		$vote_p = array(':uniacid'=>$_W['uniacid']);
		$ds = pdo_fetchall($vote_s,$vote_p);
	 
        foreach ($ds as $k => $v) {
            $r = array();
            $r['title'] = $v['title'];
            $r['description'] = $v['description'];
            $r['thumb'] = tomedia($v['fmimg']);
            $r['mid'] = $v['id'];
            $ds[$k]['entry'] = $r;
        }
 	 	
		include $this->template('sys/list');
		break;
	case 'edit':
		 
		  
		break;
	default:
		 
 
}


















