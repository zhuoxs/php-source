<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/storeprice";

if($_GPC['op']=='add'){
    $limittype=pdo_getall('mzhk_sun_storelimittype',array('uniacid'=>$_W['uniacid']));

	/*=========分销插件 S===========*/
	//判断是否有分销插件且开启了分销
	include_once IA_ROOT . '/addons/mzhk_sun/inc/func/distribution.php';
	$distribution = new Distribution();
	$isopendistribution = $distribution->getdistributionset();
	/*=========分销插件 E===========*/

    $template = "web/storeprice_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    // $limittype = $_GPC['limittype'];
    // if(!empty($limittype) || $limittype!=0){
    //     $limittype_array = explode("$$$",$limittype);
    //     $data['lt_name']=$limittype_array[1];
    //     $data['lt_day']=$limittype_array[2];
    //     $data['lt_id']=$limittype_array[0];
    // }

	/*=========分销插件 S===========*/
	//判断是否有分销插件且开启了分销
	include_once IA_ROOT . '/addons/mzhk_sun/inc/func/distribution.php';
	$distribution = new Distribution();
	$isopendistribution = $distribution->getdistributionset();
	$distributioncomtype = array("","%","元");
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

    $data['lt_name']=$_GPC['lt_name'];
    $data['lt_day']=$_GPC['lt_day'];
    $data['money']=$_GPC['money'];
    $data['sort']=$_GPC['sort'];
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_storelimit',$data);
        if($res){
            message('添加成功',$this->createWebUrl('storeprice'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_storelimit', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('storeprice'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_storelimit',array('uniacid'=>$_W['uniacid'],'id'=>$id));

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

    $limittype=pdo_getall('mzhk_sun_storelimittype',array('uniacid'=>$_W['uniacid']));

    $template = "web/storeprice_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_storelimit',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('storeprice'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{
    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_storelimit") ." ".$where." order by sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_storelimit") . " " .$where." order by sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);


}

include $this->template($template);