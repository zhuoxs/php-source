<?php
defined('IN_IA') or exit('Access Denied');

class Order_WeliamController {
	
	public function record() {
		global $_W, $_GPC;
		$keytype = $_GPC['keywordtype'];
		$keyword = $_GPC['keyword'];
		$where['uniacid'] = $_W['uniacid'];
		$pindex = max(1, $_GPC['page']);
		
		if($_GPC['keyword']){
			$keyword = $_GPC['keyword'];
			if($_GPC['keywordtype'] == 2){
				$where['mid'] = $keyword;
			}else if($_GPC['keywordtype'] == 3){
				$where['goodsid'] = $keyword;
			}else if($_GPC['keywordtype'] == 4){
				$where['integral>'] = $keyword;
			}else if($_GPC['keywordtype'] == 5){
				$where['integral<'] = $keyword;
			}else if($_GPC['keywordtype'] == 1){
				$params[':name'] = "%{$keyword}%";
				$members = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')." WHERE uniacid = {$_W['uniacid']}  AND nickname LIKE :name",$params);
				if($members){
					$mids = "(";
					foreach ($members as $key => $v) {
						if($key == 0){
							$mids.= $v['id'];
						}else{
							$mids.= ",".$v['id'];
						}	
					}
					$mids.= ")";
					$where['mid#'] = $mids;
				}else{
					$where['mid'] = 0;
				}
			}
		}
		
		if($_GPC['status']){
			$where['status'] = $_GPC['status'];
		}
		
		if ($_GPC['time_limit']) {
			$time_limit = $_GPC['time_limit'];
			$starttime = strtotime($_GPC['time_limit']['start']);
			$endtime = strtotime($_GPC['time_limit']['end']);
			$where['createtime>'] = $starttime;
			$where['createtime<'] = ($endtime + 24 * 3600);
		}
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		$listData = Util::getNumData("*",PDO_NAME.'consumption_record',$where,'createtime desc', $pindex, 10, 1);
		$list = $listData[0];
		foreach ($list as $key => &$v) {
			$member = pdo_get(PDO_NAME . 'member', array('id' => $v['mid']), array('nickname', 'avatar'));
			$v['nickname'] = $member['nickname'];
			$v['avatar'] = $member['avatar'];
			$goods = pdo_get(PDO_NAME.'consumption_goods', array('id' => $v['goodsid']), array('thumb','title'));
			$v['goodsthumb'] = $goods['thumb'];
			$v['goodstitle'] = $goods['title'];
			$express = pdo_get(PDO_NAME.'express', array('id' => $v['expressid']), array('sendtime','receivetime'));
			$v['sendtime'] = $express['sendtime'];
			$v['receivetime'] = $express['receivetime'];
		}
		$pager = $listData[1];
		include  wl_template('consumption/order');
	}
}