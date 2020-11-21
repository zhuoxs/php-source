<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('mzhk_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$ship_type = $info["ship_type"]?explode(",",$info["ship_type"]):array();

//挚能云导入
$zid = intval($_GPC["zid"]);
if($zid>0){
    $z_goods = $this->doWebdownloadGoods($zid);

    if($z_goods['code']==0){
		$info = $z_goods['data'];
		$info["lb_imgs"] = implode(",",$z_goods['data']['lb_imgs']);
	}else{
		message($z_goods['msg'],'','error');
	}
}

$lid = 2;
$lottery=0;

//判断抽奖插件是否安装
if(pdo_tableexists("mzhk_sun_plugin_lottery_system")){

    $lottery = 1;

    $goodslottery=pdo_getall('mzhk_sun_plugin_lottery_goods',array('uniacid'=>$_W['uniacid'],'status'=>2,'isbuy'=>1));

}
//获取分类
$goodscate=pdo_getall('mzhk_sun_goodscate',array('uniacid'=>$_W['uniacid']));

//判断是否有积分插件
$scoretaskplugin=0;
if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
    $scoretaskplugin=1;
}

//判断是否有云店插件
if(pdo_tableexists("mzhk_sun_cloud_set")){
    $cloudshop = 1;
}

//判断是否有总佣金
if(pdo_tableexists("mzhk_sun_distribution_set")){
    $dsystem = pdo_get('mzhk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array('commission_type'));
	if($dsystem['commission_type']==1){
		$totalset = 1;
	}
}

//==S===公众号助手使用
//判断是否有公众号助手
if(pdo_tableexists("mzhk_sun_wechat_set")){
    $wechat_have = 1;
}
//==E===公众号助手使用

$noshow_vipprice = 1;

if($info['zs_imgs']){
    if(strpos($info['zs_imgs'],',')){
        $zs_imgs= explode(',',$info['zs_imgs']);
    }else{
        $zs_imgs=array(
            0=>$info['zs_imgs']
        );
    }
}
if($info['lb_imgs']){
    if(strpos($info['lb_imgs'],',')){
        $lb_imgs= explode(',',$info['lb_imgs']);
    }else{
        $lb_imgs=array(
            0=>$info['lb_imgs']
        );
    }
}
if($info['img_details']){
    if(strpos($info['img_details'],',')){
        $img_details= explode(',',$info['img_details']);
    }else{
        $img_details=array(
            0=>$info['img_details']
        );
    }
}

if($info['expirationtime']>0){
    $info['expirationtime'] = date("Y-m-d H:i:s",$info['expirationtime']);
}else{
    $info['expirationtime'] = "";
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

//判断是否开启商品返利
$system = pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
$rebate = $system['rebate_open'];

if(checksubmit('submit')){
    // p($_GPC);die;
    if($_GPC['goods_name']==null) {
        message('请您填写商品名称', '', 'error');
    }elseif($_GPC['pic']==null){
        message('请您上传图片','','error');
    }elseif($_GPC['content']==null){
        message('详情不能为空','','error');
    }elseif($_GPC['num']==null){
        message('库存不能为零','','error');
    }elseif($_GPC['astime']>=$_GPC['antime']){
        message('活动开始的时间必须比活动结束的时间要早','','error');
    }elseif(empty($_GPC['bid'])){
        message('请选择门店','','error');
    }

	if(pdo_tableexists("mzhk_sun_distribution_set")){
		$dsystem = pdo_get('mzhk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array('commission_type'));
		if($dsystem['commission_type']==1){ //开启总佣金
			//分销只能选择百分比
			if($_GPC['distribution_open']==1){
				if($_GPC['distribution_commissiontype']==2){
					message('开启总佣金后，分销佣金类型只能为百分比','','error');
				}
			}
		}
	}

    //砍价
    if($_GPC['shopprice']==null){
        message('请您填写商品价格','','error');
    }
    
    if(floatval($_GPC['kjprice'])<0){
        message('商品砍价价格必须大于等于0','','error');
    }

    if($lottery==1){
        if($_GPC['iscj']==1){
            if(empty($_GPC['cjid'])){
                message('请选择抽奖项目','','error');
            }
        }
        $data['iscj']=$_GPC['iscj'];
        $data['cjid']=$_GPC['cjid'];
    }
    

    //处理图片
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }
	if($_GPC['img_details']){
        $data['img_details']=implode(",",$_GPC['img_details']);
    }else{
        $data['img_details']='';
    }

    //20180504 @淡蓝海寓 商品表门店保存
    $brand = $_GPC['bid'];
    $brandarr = array();
    if(!empty($brand)){
        $brandarr = explode("$$$",$brand);
    }
    $data['bid'] = $brandarr[0];
    $data['bname'] = $brandarr[1];

    $data['is_vip'] = $_GPC["is_vip"];
    $data['cutnum'] = $_GPC["cutnum"];
    $data['canrefund'] = $_GPC["canrefund"];

    if($_GPC["ship_type"]){
        $data['ship_type'] = implode(",",$_GPC["ship_type"]);
    }else{
        $data['ship_type'] = "1";
    }
    $data['ship_delivery_fee'] = $_GPC["ship_delivery_fee"];
    $data['ship_delivery_time'] = $_GPC["ship_delivery_time"];
    $data['ship_delivery_way'] = $_GPC["ship_delivery_way"];
    $data['ship_express_fee'] = $_GPC["ship_express_fee"];

    $data['sort'] = intval($_GPC["sort"]);
    $data['stocktype'] = intval($_GPC["stocktype"]);
    $data['mustlowprice'] = intval($_GPC["mustlowprice"]);
    
    $data['qgprice'] = $_GPC['qgprice'];
    $data['kjprice'] = $_GPC['kjprice'];
    $data['ptprice'] = $_GPC['ptprice'];
    $data['ptnum'] = $_GPC['ptnum'];
    $data['shopprice']=$_GPC['shopprice'];
    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['goods_name'];
    $data['content']=html_entity_decode($_GPC['content']);
    //$data['content']=$_GPC['content'];
    $data['lid']=2;
    $data['status']=2;
    $data['tid']=$_GPC['tid'];
	$data['recdetail']=$_GPC['recdetail'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['probably']=$_GPC['survey'];
    $data['pic'] = $_GPC['pic'];
    $data['bid'] = $_GPC['bid'];
    $data['num'] = $_GPC['num'];
    $data['astime'] = $_GPC['astime'];
    $data['antime'] = $_GPC['antime'];
	$data['cateid'] = $_GPC['cateid'];
	$data['reccloud'] = $_GPC['reccloud'];
	$data['totalcommission'] = $_GPC['totalcommission'];

	$data['isjoin'] = $_GPC['isjoin'];
	$data['rebate_open'] = $_GPC['rebate_open'];
	$data['rebatetype'] = $_GPC['rebatetype'];
	$data['rebatemoney'] = $_GPC['rebatemoney'];
	$data['ordernum'] = $_GPC['ordernum'];

	$data['fseenum'] = $_GPC['fseenum'];
	$data['fsharenum'] = $_GPC['fsharenum'];
	$data['fjoinnum'] = $_GPC['fjoinnum'];

    $data['limitnum'] = intval($_GPC['limitnum']);
    $data['index_img'] = $_GPC['index_img'];
	$data['index3_img'] = $_GPC['index3_img'];

	$data["kjsection_open"] = $_GPC["kjsection_open"];
	$data["sctionpnum1"] = $_GPC["sctionpnum1"];
	$data["sctionpnum11"] = $_GPC["sctionpnum11"];
	$data["sctionpnum2"] = $_GPC["sctionpnum2"];
	$data["sctionpnum22"] = $_GPC["sctionpnum22"];
	$data["sctionpnum3"] = $_GPC["sctionpnum3"];
	$data["sctionpnum33"] = $_GPC["sctionpnum33"];
	$data["sctionmoney1"] = $_GPC["sctionmoney1"];
	$data["sctionmoney2"] = $_GPC["sctionmoney2"];
	$data["sctionmoney3"] = $_GPC["sctionmoney3"];

	$data['open_num']=$_GPC['open_num'];
	$data['day_num']=$_GPC['day_num'];
	$data['open_friend']=$_GPC['open_friend'];
	$data['friend_num']=$_GPC['friend_num'];


	if($scoretaskplugin==1){
		$data['money_rate'] = $_GPC['money_rate'];
		$data['score_rate'] = $_GPC['score_rate'];
	}

    if($_GPC['kjbfb']==null){
        $data['kjbfb']="20%";
    }else{
        $data['kjbfb'] = $_GPC['kjbfb'].'%';
    }
    if($_GPC['biaoti']==null){
        $data['biaoti']="老铁,快来帮我砍一刀，快来支援我";
    }else{
        $data['biaoti'] = $_GPC['biaoti'];
    }
    $data['expirationtime'] = strtotime($_GPC['expirationtime']);

    //==S===公众号助手使用
    $data['wechat_media_img'] = $_GPC['wechat_media_img'];
    $data['media_id_time'] = 0;//清除媒体id保存时间
    //==E===公众号助手使用

    if(empty($_GPC['gid'])){
        $res = pdo_insert('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('kjlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('mzhk_sun_goods', $data, array('gid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('kjlist',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/addkjlist');