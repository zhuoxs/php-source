<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_polyapi_key') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$time = time();
			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['merchid'] = 0;
			$data['status'] = 1;
			$data['appkey'] = trim($_GPC['appkey']);
			$data['token'] = trim($_GPC['token']);
			$data['appsecret'] = trim($_GPC['appsecret']);
			$data['status'] = intval($_GPC['status']);

			if (empty($data['appkey'])) {
				show_json(0, '请输入AppKey');
			}

			if (empty($data['appsecret'])) {
				show_json(0, '请输入AppSecret');
			}

			if (empty($data['token'])) {
				show_json(0, '请输入Token');
			}

			if (empty($item)) {
				$data['createtime'] = $time;
				pdo_insert('ewei_shop_polyapi_key', $data);
			}
			else {
				$data['updatetime'] = $time;
				pdo_update('ewei_shop_polyapi_key', $data, array('uniacid' => $_W['uniacid']));
			}

			plog('polyapi.set.edit', '修改基本设置');
			show_json(1);
		}

		$this->update();
		include $this->template();
	}

	public function update()
	{
		global $_W;
		global $_GPC;
		$item = pdo_fetch('select code from ' . tablename('ewei_shop_express') . ' where express=:express limit 1', array(':express' => 'shunfeng'));

		if (empty($item['code'])) {
			$data = array();
			$data['shunfeng'] = 'JH_014';
			$data['shentong'] = 'JH_005';
			$data['yunda'] = 'JH_003';
			$data['tiantian'] = 'JH_004';
			$data['yuantong'] = 'JH_002';
			$data['zhongtong'] = 'JH_006';
			$data['ems'] = 'JH_001';
			$data['huitongkuaidi'] = 'JH_012';
			$data['quanfengkuaidi'] = 'JH_009';
			$data['zhaijisong'] = 'JH_007';
			$data['aae'] = 'JHI_049';
			$data['anxindakuaixi'] = 'JH_131';
			$data['bht'] = 'JHI_008';
			$data['baifudongfang'] = 'JH_062';
			$data['coe'] = 'JHI_038';
			$data['datianwuliu'] = 'JH_050';
			$data['debangwuliu'] = 'JH_011';
			$data['dhl'] = 'JHI_002';
			$data['dpex'] = 'JHI_011';
			$data['dsukuaidi'] = 'JH_049';
			$data['disifang'] = 'JHI_080';
			$data['fedex'] = 'JHI_014';
			$data['feikangda'] = 'JH_088';
			$data['feikuaida'] = 'JH_151';
			$data['guotongkuaidi'] = 'JH_010';
			$data['ganzhongnengda'] = 'JH_033';
			$data['guangdongyouzhengwuliu'] = 'JH_135';
			$data['gongsuda'] = 'JH_039';
			$data['hengluwuliu'] = 'JH_048';
			$data['huaxialongwuliu'] = 'JH_129';
			$data['haihongwangsong'] = 'JH_132';
			$data['haiwaihuanqiu'] = 'JHI_013';
			$data['jiayiwuliu'] = 'JH_035';
			$data['jinguangsudikuaijian'] = 'JH_041';
			$data['jixianda'] = 'JH_040';
			$data['jiajiwuliu'] = 'JH_030';
			$data['jymwl'] = 'JH_054';
			$data['jindawuliu'] = 'JH_079';
			$data['jialidatong'] = 'JH_060';
			$data['jykd'] = 'JHI_046';
			$data['kuaijiesudi'] = 'JH_008';
			$data['lianb'] = 'JH_122';
			$data['lianhaowuliu'] = 'JH_021';
			$data['longbanwuliu'] = 'JH_019';
			$data['lijisong'] = 'JH_044';
			$data['lejiedi'] = 'JH_043';
			$data['minghangkuaidi'] = 'JH_100';
			$data['meiguokuaidi'] = 'JHI_044';
			$data['menduimen'] = 'JH_036';
			$data['ocs'] = 'JHI_012';
			$data['quanchenkuaidi'] = 'JH_055';
			$data['quanjitong'] = 'JH_127';
			$data['quanritongkuaidi'] = 'JH_029';
			$data['quanyikuaidi'] = 'JH_020';
			$data['rufengda'] = 'JH_017';
			$data['santaisudi'] = 'JH_065';
			$data['shenghuiwuliu'] = 'JH_066';
			$data['sue'] = 'JH_016';
			$data['shengfeng'] = 'JH_082';
			$data['saiaodi'] = 'JH_042';
			$data['tiandihuayu'] = 'JH_018';
			$data['tnt'] = 'JHI_003';
			$data['ups'] = 'JHI_004';
			$data['wxwl'] = 'JH_115';
			$data['xinbangwuliu'] = 'JH_022';
			$data['xinfengwuliu'] = 'JH_023';
			$data['yafengsudi'] = 'JH_075';
			$data['yibangwuliu'] = 'JH_064';
			$data['youshuwuliu'] = 'JH_013';
			$data['youzhengguonei'] = 'JH_077';
			$data['yuanchengwuliu'] = 'JH_024';
			$data['yuanweifeng'] = 'JH_141';
			$data['yuanzhijiecheng'] = 'JH_126';
			$data['yuntongkuaidi'] = 'JH_145';
			$data['yuefengwuliu'] = 'JH_068';
			$data['yad'] = 'JH_067';
			$data['yinjiesudi'] = 'JH_148';
			$data['zhongtiekuaiyun'] = 'JH_015';
			$data['zhongyouwuliu'] = 'JH_027';
			$data['zhongxinda'] = 'JH_086';
			$data['zhimakaimen'] = 'JH_026';
			$data['annengwuliu'] = 'JH_059';
			$data['jd'] = 'JH_046';

			foreach ($data as $k => $v) {
				pdo_update('ewei_shop_express', array('code' => $v), array('express' => $k));
			}
		}
	}
}

?>
