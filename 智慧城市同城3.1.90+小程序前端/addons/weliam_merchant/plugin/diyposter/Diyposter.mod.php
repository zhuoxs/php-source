<?php 
defined('IN_IA') or exit('Access Denied');

class Diyposter {
	
	static function getgzqrcode($gid, $type) {
		global $_W;
		$qrid = pdo_getcolumn(PDO_NAME.'qrcode', array('uniacid' => $_W['uniacid'], 'sid' => $gid, 'type' => 2, 'remark' => $type), 'qrid');
      	if($qrid){
        	$qrurl = pdo_get('qrcode', array('id' => $qrid, 'uniacid' => $_W['uniacid']), array('url', 'ticket'));
        }
		if (empty($qrid) || empty($qrurl) ) {
			Weixinqrcode::createkeywords('商品关注二维码:Diyposter', 'weliam_merchant_diyposter');
			$result = Weixinqrcode::createqrcode('商品关注二维码:Diyposter', 'weliam_merchant_diyposter', 2, 1, -1, $type);
			if(!is_error($result)) {
				$qrid = $result;
				pdo_update(PDO_NAME.'qrcode', array('sid' => $gid), array('uniacid' => $_W['uniacid'], 'qrid' => $qrid));
			}
		}
      	if(empty($qrurl)){
        	$qrurl = pdo_get('qrcode', array('id' => $qrid, 'uniacid' => $_W['uniacid']), array('url', 'ticket'));
        }
		return $qrurl;
	}

	static function Processor($message) {
		global $_W;
		if (strtolower($message['msgtype']) == 'event'){
			//获取数据
			$returnmess = array();
			$qrid = Weixinqrcode::get_qrid($message);
			$member = Member::mc_init_fans_info($message['from']);
			
			$qrinfo = self::geturlinfo($qrid);
			
			//发送消息
			if(strexists($qrinfo['qrcode']['remark'], 'wxapp')){
				$wxapp_uniacid = Wxapp::get_wxapp_uniacid($_W['uniacid']);
				$wxapp = uni_fetch($wxapp_uniacid);
				Weixinqrcode::send_text($qrinfo['title']."<a href='{$qrinfo['url']}' data-miniprogram-appid='{$wxapp['key']}' data-miniprogram-path='wxapp_web/pages/view/index?scene=gzqrcode:{$qrid}%23'>点击查看详情</a>", $message);
			} else {
				$returnmess = array(array('title' => urlencode($qrinfo['title']),'description' => urlencode('数量有限，手慢无~~'),'picurl' => tomedia($qrinfo['imgurl']),'url' => $qrinfo['url']));
				Weixinqrcode::send_news($returnmess, $message);
			}
		}
	}

	static function geturlinfo($qrid) {
		global $_W;
		$qrcode = pdo_get(PDO_NAME.'qrcode',array('uniacid' => $_W['uniacid'],'qrid' => $qrid), array('sid', 'remark'));
		$qrarray = explode(":", $qrcode['remark']);
		
		//获取商品信息和链接
		if(strexists($qrcode['remark'], 'rush')){
			$rushgoods = Rush::getSingleActive($qrcode['sid'], 'name,thumb,aid');
			$title = $rushgoods['name'];
			$imgurl = $rushgoods['thumb'];
			$url = app_url('rush/home/detail', array('id' => $qrcode['sid'], 'invitid' => $qrarray[0], 'aid' => $rushgoods['aid']));
		}
		if(strexists($qrcode['remark'], 'wlcoupon')){
			$wlCoupon = wlCoupon::getSingleCoupons($qrcode['sid'], 'title,logo,aid');
			$title = $wlCoupon['title'];
			$imgurl = $wlCoupon['logo'];
			$url = app_url('wlcoupon/coupon_app/couponsdetail', array('id' => $qrcode['sid'], 'invitid' => $qrarray[0], 'aid' => $wlCoupon['aid']));
		}
		if(strexists($qrcode['remark'], 'wlfightgroup')){
			$group = Wlfightgroup::getSingleGood($qrcode['sid'],'name,logo,aid');
			$title = $group['name'];
			$imgurl = $group['logo'];
			$url = app_url('wlfightgroup/fightapp/goodsdetail', array('id' => $qrcode['sid'], 'invitid' => $qrarray[0], 'aid' => $group['aid']));
		}
		if(strexists($qrcode['remark'], 'groupon')){
			$groupon = pdo_get('wlmerchant_groupon_activity',array('id' => $qrcode['sid']),array('name','thumb','aid'));
			$title = $groupon['name'];
			$imgurl = $groupon['thumb'];
			$url = app_url('groupon/grouponapp/groupondetail', array('cid' => $qrcode['sid'], 'invitid' => $qrarray[0], 'aid' => $groupon['aid']));
		}
		if(strexists($qrcode['remark'], 'bargain')){
			$bargain = pdo_get('wlmerchant_bargain_activity',array('id' => $qrcode['sid']),array('name','thumb','aid'));
			$title = $bargain['name'];
			$imgurl = $bargain['thumb'];
			$url = app_url('bargain/bargain_app/bargaindetail', array('cid' => $qrcode['sid'], 'userid' => $qrarray[3], 'invitid' => $qrarray[0], 'aid' => $groupon['aid']));
		}
		
		return array('title' => $title, 'imgurl' => $imgurl, 'url' => $url, 'qrcode' => $qrcode);
	}
}