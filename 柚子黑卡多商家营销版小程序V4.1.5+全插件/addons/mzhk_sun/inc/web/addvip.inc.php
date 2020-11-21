<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('mzhk_sun_vip',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

//判断是否有积分插件
$scoretaskplugin=0;
if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
    $scoretaskplugin=1;
}

/*=========分销插件 S===========*/
//判断是否有分销插件且开启了分销
include_once IA_ROOT . '/addons/mzhk_sun/inc/func/distribution.php';
$distribution = new Distribution();
$isopendistribution = $distribution->getdistributionset();
$distributioncomtype = array("","%","元");
if(intval($info["distribution_commissiontype"])==0){
    $info["distribution_commissiontype"] = 1;
}
//先判断是否开启分销
if($isopendistribution){
    if(checksubmit('submit')){
        $data["distribution_open"] = $_GPC["distribution_open"];
        $data["distribution_commissiontype"] = $_GPC["distribution_commissiontype"];
        $data["firstmoney"] = $_GPC["firstmoney"];
        $data["secondmoney"] = $_GPC["secondmoney"];
        $data["thirdmoney"] = $_GPC["thirdmoney"];
    }
}
/*=========分销插件 E===========*/

//获取赠送优惠券
$now = date("Y-m-d H:i:s",time());
$sql ="select id,title from ".tablename('mzhk_sun_coupon')." where astime<='".$now."' and antime>='".$now."' and allowance>0 and isvip=0 and uniacid=".$_W['uniacid']." ";
$coupons = pdo_fetchall($sql);

//获取赠送普通商品
$sql ="select gid,gname from ".tablename('mzhk_sun_goods')." where astime<='".$now."' and antime>='".$now."' and num>0 and is_vip=0 and isshelf=1 and status=2 and lid=1 and uniacid=".$_W['uniacid']." ";
$goods = pdo_fetchall($sql);


if(checksubmit('submit')){
    
	// p($_GPC);die;
    if(empty($_GPC['title'])) {
        message('请您写VIP的名称', '', 'error');
    }
    if(empty($_GPC['day'])){
        message('请您写vip期限时间','','error');
    }
    if($_GPC['price']=='' || $_GPC['price']==null || $_GPC['price']<0){
        message('请您写VIP价格','','error');
    }
    if(empty($_GPC['prefix'])){
        message('激活码前缀不能为空','','error');
    }
    $isTure=preg_match('/^[0-9a-zA-Z]+$/',$_GPC['prefix']);
    if(!$isTure){
        message('激活码前缀只允许输入数字、英文和字母！！！','','error');
    }
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['day']=$_GPC['day'];
    $data['price']=$_GPC['price'];
    $data['prefix']=$_GPC['prefix'];

	if($scoretaskplugin==1){
		$data['money_rate'] = $_GPC['money_rate'];
		$data['score_rate'] = $_GPC['score_rate'];
	}

    $data['status']=1;
    $data['time']=time();
    if(!$_GPC['jihuoma']){
        $data['jihuoma']='MZ'.time() . mt_rand(100, 999);;
    }

	$data['buyvipset']=$_GPC['buyvipset'];
	if($data['buyvipset']==0){
		$data['cid']=0;
		$data['gid']=0;
		$data['returnmoney']=0;
	}elseif($data['buyvipset']==2){
		$data['cid']=$_GPC['cid'];
		$data['gid']=0;
		$data['returnmoney']=0;
	}elseif($data['buyvipset']==3){
		$data['cid']=0;
		$data['gid']=$_GPC['gid'];
		$data['returnmoney']=0;
	}elseif($data['buyvipset']==1){
		$data['cid']=0;
		$data['gid']=0;
		$data['returnmoney']=$_GPC['returnmoney'];
	}
	

    if(empty($_GPC['id'])){
        $res = pdo_insert('mzhk_sun_vip', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('vip',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('mzhk_sun_vip', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('vip',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/addvip');