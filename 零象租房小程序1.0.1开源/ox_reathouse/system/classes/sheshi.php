<?php

class Sheshi
{

	public function add()
	{
		global $_W;
		$sheshi = array(
			['name'=>'冰箱','icon'=>'addons/ox_reathouse/icon/bingxiang.png'],
			['name'=>'床','icon'=>'addons/ox_reathouse/icon/chuang.png'],
			['name'=>'电磁炉','icon'=>'addons/ox_reathouse/icon/diancilu.png'],
			['name'=>'电视','icon'=>'addons/ox_reathouse/icon/tv.png'],
			['name'=>'空调','icon'=>'addons/ox_reathouse/icon/kongtiao.png'],
			['name'=>'宽带','icon'=>'addons/ox_reathouse/icon/kuandai.png'],
			['name'=>'暖气','icon'=>'addons/ox_reathouse/icon/nuanqi.png'],
			['name'=>'燃气灶','icon'=>'addons/ox_reathouse/icon/ranqizao.png'],
			['name'=>'热水器','icon'=>'addons/ox_reathouse/icon/reshuiqi.png'],
			['name'=>'沙发','icon'=>'addons/ox_reathouse/icon/shafa.png'],
			['name'=>'书桌','icon'=>'addons/ox_reathouse/icon/shuzhuo.png'],
			['name'=>'微波炉','icon'=>'addons/ox_reathouse/icon/weibolu.png'],
			['name'=>'洗衣机','icon'=>'addons/ox_reathouse/icon/xiyiji.png'],
			['name'=>'阳台','icon'=>'addons/ox_reathouse/icon/yangtai.png'],
			['name'=>'衣柜','icon'=>'addons/ox_reathouse/icon/yigui.png'],
			['name'=>'油烟机','icon'=>'addons/ox_reathouse/icon/youyanji.png'],
		);
		$data = array(
			'uniacid'=>$_W['uniacid'],
			'create_time'=>time(),
		);
		foreach ($sheshi as $value){
			$data['name'] = $value['name'];
			$data['icon'] = $value['icon'];
			pdo_insert('ox_reathouse_facility',$data);
		}
		return;
	}

}
?>
