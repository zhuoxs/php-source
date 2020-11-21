<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
/*if($_W['config']['setting']['authkey']==$_GPC['authkey']){
	switch($_GPC['mo']) {
			case '1':
				$prize = pdo_getall('gicai_fwyzm_prize',array('uniacid'=>$_W['uniacid'],'fid'=>$_GPC['fid']));
				print_r($prize);
			break;
			case '2':
				$code_data = pdo_getall('gicai_fwyzm_code_data',array('uniacid'=>$_W['uniacid'],'fid'=>$_GPC['fid']));
				print_r($code_data);
			break;	
			default:
				echo "mo=1";
			break;
	}
}*/
if(pdo_tableexists('gicai_fwyzm_code_data_use')) {
	if(!pdo_fieldexists('gicai_fwyzm_code_data_use','did')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data_use')." ADD COLUMN `did` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data_use','pid')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data_use')." ADD COLUMN `pid` int(10) NOT NULL;");
	}
}
if(pdo_tableexists('gicai_fwyzm_code_data')) {
	if(!pdo_fieldexists('gicai_fwyzm_code_data','djtype')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data')." ADD COLUMN `djtype` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data','djdata')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data')." ADD COLUMN `djdata` text NOT NULL;");
	}
}
if(pdo_tableexists('gicai_fwyzm_code')) {
	if(!pdo_fieldexists('gicai_fwyzm_code','scdjxx')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `scdjxx` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','scqtzx')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `scqtzx` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','dengji')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `dengji` text NOT NULL;");
	}
}
