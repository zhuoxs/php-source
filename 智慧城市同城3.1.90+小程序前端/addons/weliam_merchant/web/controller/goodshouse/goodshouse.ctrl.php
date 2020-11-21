<?php
defined('IN_IA') or exit('Access Denied');

class Goodshouse_WeliamController{
	/*
	 * 入口函数
	 */
	
	function goodsList(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where =array('aid'=>$_W['aid']);
		if (!empty($_GPC['keyword'])) {
			if(!empty($_GPC['keywordtype'])){
				switch($_GPC['keywordtype']){
					case 1: $where['@name@'] = $_GPC['keyword'];break;
					case 2: $where['@id@'] = $_GPC['keyword'];break;
					case 3: $where['@id@'] = $_GPC['keyword'];break;
					case 4: $where['@code@'] = $_GPC['keyword'];break;
					default:break;
				}
			}
		}
		$goodsData = Rush::getNumGoods('*', $where, 'displayorder DESC', $pindex, $psize, 1);
		$goodses = $goodsData[0];
		$pager = $goodsData[1];
		foreach($goodses as $key =>&$value){
			$value['sName'] = Util::idSwitch('sid', 'sName', $value['sid']);
		}
		include wl_template('goodshouse/goods_list');
	}
	
	function createGoods(){
		global $_W,$_GPC;
		if($_W['isajax']){
			$img = $_GPC['data_img'];
			$tags = $_GPC['data_tag'];
			$len = count($img);
			$tag = array();
			for ($k = 0; $k < $len; $k++) {
				$tag[$k]['data_img'] = $img[$k];
				$tag[$k]['data_tag'] = $tags[$k];
			}
			$goods = $_GPC['goods'];
			$goods['detail'] = htmlspecialchars_decode($goods['detail']);
			$goods['thumbs'] = serialize($goods['thumbs']);
			$goods['tag'] = serialize($tag);
			$res = Rush::saveGoodsHouse($goods);
			wl_message(array('errno'=>1,'message'=>'添加成功'));
		}
		include wl_template('goodshouse/creategoods');
	}
	function editGoods(){
		global $_W,$_GPC;
		$goods = Rush::getSingleGoods($_GPC['id'],'*');
		$merchant = Rush::getSingleMerchant($goods['sid'],'id,storename,logo');
		$goods['thumbs'] = unserialize($goods['thumbs']);
		$goods['tag'] = unserialize($goods['tag']);
	//	wl_debug($goods['tag']);
		if($_W['isajax']){
			$img = $_GPC['data_img'];
			$tags = $_GPC['data_tag'];
			$len = count($img);
			$tag = array();
			for ($k = 0; $k < $len; $k++) {
				$tag[$k]['data_img'] = $img[$k];
				$tag[$k]['data_tag'] = $tags[$k];
			}
			$goods = $_GPC['goods'];
			$goods['detail'] = htmlspecialchars_decode($goods['detail']);
			$goods['thumbs'] = serialize($goods['thumbs']);
			$goods['tag'] = serialize($tag);
			$res = Rush::updateGoods($goods,array('id' => $_GPC['id']));
			wl_message(array('errno'=>1,'message'=>'更新成功'));
		}
		include wl_template('goodshouse/creategoods');
	}
	
	function delete(){
		global $_W,$_GPC;	
		$id = $_GPC['id'];
		$res = Rush::deleteGoods(array('id' => $id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
		}
	}
	function tag() {
		include wl_template('goodshouse/imgandtag');
	}
	function selectMerchant(){
		global $_W,$_GPC;
		$where =array();
		$where['uniacid'] = $_W['uniacid'];
		$where['aid'] = $_W['aid'];
		$where['status'] = 2;
		$where['enabled'] = 1;
		if($_GPC['keyword']) $where['@storename@'] = $_GPC['keyword'];
		if($_GPC['enabled']) $where['enabled'] = $_GPC['enabled'];
		$merchants = Rush::getNumMerchant('id,storename,logo',$where,'ID DESC',0,0,0);
		$merchants = $merchants[0];
		foreach ($merchants as $key => &$va) {
			$va['logo'] = tomedia($va['logo']);
		}
		include wl_template('goodshouse/selectMerchant');
	}
	function copyGoods(){
		global $_W,$_GPC;	
		$id = $_GPC['id'];
		$res = pdo_get(PDO_NAME.'goodshouse',array('id'=>$id));
		unset($res['id']);
		pdo_insert(PDO_NAME.'goodshouse',$res);
		wl_message(array('errno'=>0,'message'=>'复制成功'));
	}
}

