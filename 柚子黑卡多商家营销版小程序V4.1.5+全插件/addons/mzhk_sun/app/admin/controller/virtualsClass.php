<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class virtualsClass extends BaseClass {
    private $urlarray = array("ctrl"=>"virtuals");

    public function __construct(){ 
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }


    /*虚拟设置*/
    public function virtuals(){
        global $_W, $_GPC;

		$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

		if(checksubmit('submit')){

            $data['uniacid']=$_W['uniacid'];
			$data['openvirtual']=$_GPC['openvirtual'];

            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('virtuals',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('virtuals',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/virtuals/virtuals');
    }

	/*虚拟分类列表*/
    public function virtualcate(){
        global $_W, $_GPC;

		$pageindex = max(1, intval($_GPC['page']));
		$pagesize=10;

		$list=pdo_getall('mzhk_sun_vcate',array('uniacid'=>$_W['uniacid']));
		$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_vcate") . " where uniacid=".$_W['uniacid']." order by id desc ");
		
		$pager = pagination($total, $pageindex, $pagesize);


        include $this->template('web/virtuals/virtualcate');
    }
	
	/*虚拟分类添加*/
    public function virtualcateadd(){
        global $_W, $_GPC;

		$item=pdo_get('mzhk_sun_vcate',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

		if(checksubmit('submit')){

            $data['uniacid']=$_W['uniacid'];
			$data['vcatename']=$_GPC['vcatename'];
			$data['addtime']=time();

            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_vcate',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('virtualcate'),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_vcate', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('virtualcate'),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/virtuals/virtualcateadd');
    }

	/*虚拟分类删除*/
    public function virtualcatedel(){
        global $_W, $_GPC;

		$res=pdo_delete('mzhk_sun_vcate',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res){
			message('删除成功！', $this->createWebUrl('virtualcate'), 'success');
		}else{
			message('删除失败！','','error');
		}
    }

	/*虚拟数据列表*/
    public function virtualdata(){
        global $_W, $_GPC;

		$pageindex = max(1, intval($_GPC['page']));
		$pagesize=10;

		$list=pdo_getall('mzhk_sun_virtualdata',array('uniacid'=>$_W['uniacid']));
		$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_virtualdata") . " where uniacid=".$_W['uniacid']." order by id desc ");
		if($list){
			foreach($list as $k=>$v){
				$vcate=pdo_get('mzhk_sun_vcate',array('uniacid'=>$_W['uniacid'],'id'=>$v['cateid']));
				$list[$k]['vcatename'] = $vcate['vcatename'];
			}
		}
		
		$pager = pagination($total, $pageindex, $pagesize);


        include $this->template('web/virtuals/virtualdata');
    }
	
	/*虚拟数据添加*/
    public function virtualdataadd(){
        global $_W, $_GPC;

		//分类
		$vcates = pdo_getall('mzhk_sun_vcate',array('uniacid'=>$_W['uniacid']));

		$item=pdo_get('mzhk_sun_virtualdata',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

		if(checksubmit('submit')){

            $data['uniacid']=$_W['uniacid'];
			$data['cateid']=$_GPC['cateid'];
			$data['goodsprice']=$_GPC['goodsprice'];
			$data['usernum']=$_GPC['usernum'];
			$data['goodsnum']=$_GPC['goodsnum'];
			$data['vtime']=$_GPC['vtime'];

            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_virtualdata',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('virtualdata'),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_virtualdata', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('virtualdata'),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/virtuals/virtualdataadd');
    }

	/*虚拟数据删除*/
    public function virtualdatadel(){
        global $_W, $_GPC;

		$res=pdo_delete('mzhk_sun_virtualdata',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res){
			message('删除成功！', $this->createWebUrl('virtualdata'), 'success');
		}else{
			message('删除失败！','','error');
		}
    }

	//导出虚拟数据
	public function exportdata(){
        global $_W, $_GPC;

		$sql = "select * from ".tablename('mzhk_sun_virtualdata')." where uniacid=".$_W['uniacid']." order by id asc";

		$orderlist=pdo_fetchall($sql);
		if($orderlist){
			foreach($orderlist as $k1=>$v1){
				$vcate=pdo_get('mzhk_sun_vcate',array('uniacid'=>$_W['uniacid'],'id'=>$v1['cateid']));
				$orderlist[$k1]['vcatename'] = $vcate['vcatename'];
			}
		}
		
		$export_title_str = "id,分类名称,销售额(元),用户数,订单数,时间";
		
		$export_title = explode(',',$export_title_str);
		$export_list = array(); 
		$i=1;
		foreach($orderlist as $k => $v){
			$export_list[$k]["k"] = $v["id"];
			$export_list[$k]["vcatename"] = $v["vcatename"];
			$export_list[$k]["goodsprice"] = $v["goodsprice"];
			$export_list[$k]["usernum"] = $v["usernum"];
			$export_list[$k]["goodsnum"] = $v["goodsnum"];
			$export_list[$k]["vtime"] = $v["vtime"]."\t";
			$i++;
		} 
		$exporttitle = "虚拟数据";

		exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
		exit;
    }

	

	

}