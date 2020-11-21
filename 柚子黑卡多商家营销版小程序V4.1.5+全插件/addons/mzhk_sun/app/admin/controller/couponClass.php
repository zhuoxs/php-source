<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;

class couponClass extends BaseClass {
    private $urlarray = array("ctrl"=>"coupon");
    private $tpldir = "web/coupon/";
    private $smallnavdata = array(
        array("name"=>"优惠券设置","do"=>"couponsing","urlarray"=>array("ctrl"=>"coupon")),
        array("name"=>"优惠券分类","do"=>"couponcate","urlarray"=>array("ctrl"=>"coupon")),
        array("name"=>"添加优惠券分类","do"=>"addcounponcate","urlarray"=>array("ctrl"=>"coupon")),
        array("name"=>"优惠券列表","do"=>"couponlist","urlarray"=>array("ctrl"=>"coupon")),
        array("name"=>"添加优惠券","do"=>"addcoupon","urlarray"=>array("ctrl"=>"coupon")),
    );

    public function __construct(){
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
        $GLOBALS['smallnav'] = $this->smallnav($this->smallnavdata,$_GPC["do"]);
    }

    public function couponlist(){
        global $_W, $_GPC;
//        $smallnav = $this->smallnav($this->smallnavdata,$_GPC["do"]);
        $where=" WHERE  a.uniacid=:uniacid and a.isdelete=0";
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=10;
        $data[':uniacid']=$_W['uniacid'];
        $sql="select a.*,b.bname from " . tablename("mzhk_sun_coupon") . " a"  . " left join " . tablename("mzhk_sun_brand") . " b on a.bid=b.bid" .$where." order by a.id desc ";
        $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_coupon") . " a"  . " left join " . tablename("mzhk_sun_brand") . " b on a.bid=b.bid ".$where." order by a.id desc ",$data);
        $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $list=pdo_fetchall($select_sql,$data);
        $pager = pagination($total, $pageindex, $pagesize);

        include $this->template($this->tpldir.$_GPC["do"]);
    }

    public function setstatus(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $uniacid = intval($_W['uniacid']);
        $state = intval($_GPC['state']);
        $table = 'mzhk_sun_coupon';
        $res=pdo_update($table,array('state'=>$state),array('id'=>$id,'uniacid'=>$uniacid));
        if($res){
            message('操作成功',$this->createWebUrl('couponlist',$this->urlarray),'success');
        }else{
            message('操作失败','','error');
        }
    }

    public function delete(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $ty = $_GPC["ty"];
        $table = "mzhk_sun_coupon";
        $do = "couponlist";
        if($ty=="cate"){
            $table = "mzhk_sun_couponcate";
            $do = "couponcate";
        }
        if(empty($ty)) {
            $res = pdo_update($table, array('isdelete' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
        }else{
            $res=pdo_delete($table,array('id'=>$id,'uniacid'=>$_W['uniacid']));
        }
        if($res){
            message('操作成功',$this->createWebUrl($do,$this->urlarray),'success');
        }else{
            message('操作失败','','error');
        }
    }

    public function addcoupon(){
        global $_W, $_GPC;
		//判断是否有积分插件
		$scoretaskplugin=0;
		if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
			$scoretaskplugin=1;
		}

		//判断是否有总佣金
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$dsystem = pdo_get('mzhk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array('commission_type'));
			if($dsystem['commission_type']==1){
				$totalset = 1;
			}
		}

		$info = pdo_get('mzhk_sun_coupon', array('id' => $_GPC['id']));
        $cate = pdo_getall('mzhk_sun_couponcate',array("uniacid"=>$_W['uniacid']));
		if($info['img_details']){
			if(strpos($info['img_details'],',')){
				$img_details= explode(',',$info['img_details']);
			}else{
				$img_details=array(
					0=>$info['img_details']
				);
			}
		}
        
		/*=========分销插件 S===========*/
		//判断是否有分销插件且开启了分销
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$d_set = pdo_get('mzhk_sun_distribution_set', array('uniacid' => $_W['uniacid']));
			if($d_set["status"]>0){
				$isopendistribution = [];
				$isopendistribution = $d_set;
			}
		}
		$distributioncomtype = array("","%","元");
		if(intval($info["distribution_commissiontype"])==0){
			$info["distribution_commissiontype"] = 1;
		}
		/*=========分销插件 E===========*/
		
		if (checksubmit('submit')) {
            $indata = $_GPC['indata'];
            $indata['content'] = html_entity_decode($indata['content']);
            $data = $indata;
            $data['uniacid'] = $_W['uniacid'];
			$data['totalcommission'] = $_GPC['totalcommission'];

			//先判断是否开启分销
			if($isopendistribution){
				$data["distribution_open"] = $_GPC["distribution_open"];
				$data["distribution_commissiontype"] = $_GPC["distribution_commissiontype"];
				$data["firstmoney"] = $_GPC["firstmoney"];
				$data["secondmoney"] = $_GPC["secondmoney"];
				$data["thirdmoney"] = $_GPC["thirdmoney"];
			}
			
			if($scoretaskplugin==1){
				$data['money_rate'] = $_GPC['money_rate'];
				$data['score_rate'] = $_GPC['score_rate'];
			}

			//商品详情图处理图片
			if($_GPC['img_details']){
				$data['img_details']=implode(",",$_GPC['img_details']);
			}else{
				$data['img_details']='';
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


			
            $brand = $_GPC['bid'];
            $brandarr = array();
            if(!empty($brand)){
                $brandarr = explode("$$$",$brand);
            }
            $data['bid'] = $brandarr[0];

            if (empty($_GPC['id'])) {
                $res = pdo_insert('mzhk_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
            } else {
                $res = pdo_update('mzhk_sun_coupon', $data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
            if($res){
                message('成功！', $this->createWebUrl('couponlist',$this->urlarray), 'success');
            }else{
                message('失败！');
            }
        }

		$val = json_decode($info['val'],true);

        include $this->template($this->tpldir.$_GPC["do"]);
    }

    public function couponcate(){
        global $_W, $_GPC;

        $where=" WHERE  a.uniacid=:uniacid ";
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=10;
        $data[':uniacid']=$_W['uniacid'];
        $sql="select * from " . tablename("mzhk_sun_couponcate") . " as a " .$where." order by id desc ";
        $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_coupon") . " a"  . " left join " . tablename("mzhk_sun_brand") . " b on a.bid=b.bid ".$where." order by a.id desc ",$data);
        $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $list=pdo_fetchall($select_sql,$data);
        $pager = pagination($total, $pageindex, $pagesize);


        include $this->template($this->tpldir.$_GPC["do"]);
    }

    public function addcounponcate(){
        global $_W, $_GPC;
        if (checksubmit('submit')) {
            $indata = $_GPC['indata'];
            $data = $indata;
            if (empty($_GPC['id'])) {
                $data['uniacid'] = $_W['uniacid'];
                $res = pdo_insert('mzhk_sun_couponcate', $data,array('uniacid'=>$_W['uniacid']));
            } else {
                $res = pdo_update('mzhk_sun_couponcate', $data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
            if($res){
                message('成功！', $this->createWebUrl('couponcate',$this->urlarray), 'success');
            }else{
                message('失败！');
            }
        }

        $info = pdo_get('mzhk_sun_couponcate', array('id' => $_GPC['id']));

        include $this->template($this->tpldir.$_GPC["do"]);
    }

}