<?php

defined('IN_IA') or exit('Access Denied');

class couponModel extends Model
{
	protected $tb = 'ymktv_sun_coupon';

	/**
	 * 保存数据
	 *
	 **/
	public function save($data,$id)
	{
		$data = array(
		  'weid' => $this->weid,
		  'title' => $data['title'],
		  'type' => $data['type'], //优惠券类型（1:折扣 2:代金）
		  'astime' => $data['astime'],
		  'antime' => $data['antime'],
		  'expiryDate' => intval($data['expiryDate']),
		  'allowance' => intval($data['allowance']),
		  'total' => intval($data['total']),
		  'val' => $data['val'],
		  'exchange' => $data['exchange'],
			'scene' => $data['scene'],//场景（0:普通，1:充值赠送，2:买单赠送）
		  'showIndex' => intval($data['showIndex']),
		);
		if($id){
			return $this->update(self::$coupon,$data,array('id'=>$id));
		}else{
			return $this->insert(self::$coupon,$data);
		}
	}

	/**
	 * 获取单条信息 by id
	 *
	 **/
	public function find($id)
	{
		return $this->get(self::$coupon,array('id'=>$id));
	}

/**
 * 获取所有数据
 *
 **/
	public function select()
	{
		return $this->getall(self::$coupon,array('weid'=>$this->weid));
	}

/**
 * 获取数据总量
 *
 **/

 public function count()
 {
	 $condition = array(
 		'weid' => $this->weid,
 	);
 	return $this->getcolumn(self::$member,$condition,'count(*)');
 }

 /**
  * 充值发送的优惠券
  **/
 public function getRechargeCoupon()
 {
 	$condition = array(
 		'weid' => $this->weid,
 		'scene' => 1,
 	);
 	return $this->getall(self::$coupon,$condition);
 }

 /**
 	* 买单发放的优惠券
 	*
 	**/
 public function getPayCoupon()
 {
 	$condition = array(
 		'weid' => $this->weid,
 		'scene' => 2,
 	);
 	return $this->getall(self::$coupon,$condition);
 }	

	/**
	 * 移动端展示列表
	 * 用户卡券的uid=用户id cid=卡券id
	 **/
	public function getPageList($uid,$showIndex)
	{
		$where = '';
		if($showIndex){
			$where =' AND showIndex = 1';
		}
		$sql = 'SELECT c.*,uc.id as is_selected,uc.isUsed,uc.limitTime FROM '.tablename(self::$coupon).' AS c LEFT JOIN '.tablename(self::$userCoupon).' AS uc ON c.id = uc.cid AND c.id=uc.cid AND uc.uid=:uid WHERE c.weid=:weid AND c.allowance>0 AND c.astime<=:astime AND c.antime>:antime AND scene=0 '.$where.' ORDER BY id DESC';
		$param = array(
			':weid' => $this->weid,
			':uid' => $uid,
			':astime' => date('Y-m-d H:i:s'),
			':antime' => date('Y-m-d H:i:s'),
		);
		return pdo_fetchAll($sql,$param);
	}

	/**
	 * 
	 *
	 **/
	public function isCanReceive($id)
	{
		$condition = array(
			'weid' => $this->weid,
			'id' => $id,
			'allowance >' => 0,
			'astime <=' => date('Y-m-d H:i:s'),
			'antime >' => date('Y-m-d H:i:s'),
		);
		return $this->get(self::$coupon,$condition);
	}

	/**
	 * 用户领取优惠券
	 *
	 **/
	public function receiveCouponSuccess($id, $allowance)
	{
		$condition = array(
			'weid' => $this->weid,
			'id' => $id,
			'allowance >' => 0,
			'astime <=' => date('Y-m-d H:i:s'),
			'antime >' => date('Y-m-d H:i:s'),
		);
		$new_allowance = $allowance-1;
		$data = array(
			'allowance' => $new_allowance,
		);
		return $this->update(self::$coupon,$data,$condition);
	}
}
